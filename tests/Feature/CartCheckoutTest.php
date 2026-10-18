<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartCheckoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Data checkout valid untuk pengujian.
     */
    private function validCheckoutData(): array
    {
        return [
            'customer_name' => 'Pembeli CORE',
            'whatsapp' => '081234567890',
            'fulfillment_method' => 'delivery',
            'address' => 'Jl. Contoh No. 10, Jakarta',
            'payment_method' => 'bank_transfer',
            'payment_provider' => 'bca',
        ];
    }

    /**
     * Membuat produk dummy untuk pengujian.
     */
    private function createProduct(
        int $stock = 10,
        float $price = 100000,
        float $discount = 0,
        bool $discountActive = false
    ): Product {
        $category = Category::factory()->create();

        return Product::factory()->create([
            'category_id' => $category->id,
            'name' => 'Produk Test CORE',
            'slug' => 'produk-test-' . uniqid(),
            'price' => $price,
            'stock' => $stock,
            'discount_percentage' => $discount,
            'discount_active' => $discountActive,
        ]);
    }

    /**
     * Checkout berhasil menyimpan pesanan dan detailnya.
     */
    public function test_checkout_successfully_creates_order_and_reduces_stock(): void
    {
        $product = $this->createProduct(
            stock: 10,
            price: 100000
        );

        $response = $this
            ->withSession([
                'cart' => [
                    $product->id => 2,
                ],
            ])
            ->post(
                route('checkout.store'),
                $this->validCheckoutData()
            );

        $response->assertRedirect();

        $this->assertDatabaseCount('orders', 1);

        $order = Order::with('items')->firstOrFail();

        $this->assertSame('Pembeli CORE', $order->customer_name);
        $this->assertSame('bank_transfer', $order->payment_method);
        $this->assertSame('bca', $order->payment_provider);
        $this->assertSame('pending', $order->status);
        $this->assertSame('unpaid', $order->payment_status);
        $this->assertSame('200000.00', $order->total);

        $this->assertNotEmpty($order->access_token);

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => 2,
            'unit_price' => 100000,
            'subtotal' => 200000,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 8,
        ]);

        $this->assertSame([], session('cart', []));
    }

    /**
     * Total checkout menggunakan harga setelah diskon aktif.
     */
    public function test_checkout_calculates_total_using_active_discount(): void
    {
        $product = $this->createProduct(
            stock: 10,
            price: 100000,
            discount: 20,
            discountActive: true
        );

        $response = $this
            ->withSession([
                'cart' => [
                    $product->id => 2,
                ],
            ])
            ->post(
                route('checkout.store'),
                $this->validCheckoutData()
            );

        $response->assertRedirect();

        $order = Order::firstOrFail();

        // Rp100.000 - diskon 20% = Rp80.000.
        // Dua produk menghasilkan total Rp160.000.
        $this->assertSame('160000.00', $order->total);

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'unit_price' => 80000,
            'quantity' => 2,
            'subtotal' => 160000,
        ]);
    }

    /**
     * Checkout ditolak jika stok tidak mencukupi.
     */
    public function test_checkout_is_rejected_when_stock_is_insufficient(): void
    {
        $product = $this->createProduct(
            stock: 1,
            price: 100000
        );

        $response = $this
            ->withSession([
                'cart' => [
                    $product->id => 2,
                ],
            ])
            ->post(
                route('checkout.store'),
                $this->validCheckoutData()
            );

        $response->assertSessionHasErrors('cart');

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('order_items', 0);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 1,
        ]);

        $this->assertSame(2, session('cart')[$product->id]);
    }

    /**
     * Checkout menolak metode dan penyedia pembayaran yang tidak cocok.
     */
    public function test_checkout_rejects_mismatched_payment_provider(): void
    {
        $product = $this->createProduct();

        $data = $this->validCheckoutData();

        // Transfer bank tidak boleh menggunakan DANA.
        $data['payment_provider'] = 'dana';

        $response = $this
            ->withSession([
                'cart' => [
                    $product->id => 1,
                ],
            ])
            ->post(
                route('checkout.store'),
                $data
            );

        $response->assertSessionHasErrors('payment_provider');

        $this->assertDatabaseCount('orders', 0);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 10,
        ]);
    }

    /**
     * Checkout menolak jumlah produk yang tidak valid.
     */
    public function test_checkout_rejects_invalid_cart_quantity(): void
    {
        $product = $this->createProduct();

        $response = $this
            ->withSession([
                'cart' => [
                    $product->id => 0,
                ],
            ])
            ->post(
                route('checkout.store'),
                $this->validCheckoutData()
            );

        $response->assertSessionHasErrors('cart');

        $this->assertDatabaseCount('orders', 0);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 10,
        ]);
    }

    /**
     * Checkout mewajibkan alamat jika metode pemenuhan adalah delivery.
     */
    public function test_checkout_requires_address_for_delivery(): void
    {
        $product = $this->createProduct();

        $data = $this->validCheckoutData();
        $data['address'] = '';

        $response = $this
            ->withSession([
                'cart' => [
                    $product->id => 1,
                ],
            ])
            ->post(
                route('checkout.store'),
                $data
            );

        $response->assertSessionHasErrors('address');

        $this->assertDatabaseCount('orders', 0);
    }

    /**
     * Halaman sukses pesanan menolak access token yang tidak valid.
     */
    public function test_order_success_page_rejects_an_invalid_access_token(): void
    {
        $product = $this->createProduct();

        $this
            ->withSession([
                'cart' => [
                    $product->id => 1,
                ],
            ])
            ->post(
                route('checkout.store'),
                $this->validCheckoutData()
            )
            ->assertRedirect();

        $order = Order::firstOrFail();

        $response = $this->get(route('checkout.success', [
            'orderNumber' => $order->order_number,
            'accessToken' => 'invalid-token',
        ]));

        $response->assertNotFound();
    }

    /**
     * Halaman invoice menolak access token yang tidak valid.
     */
    public function test_invoice_rejects_an_invalid_access_token(): void
    {
        $product = $this->createProduct();

        $this
            ->withSession([
                'cart' => [
                    $product->id => 1,
                ],
            ])
            ->post(
                route('checkout.store'),
                $this->validCheckoutData()
            )
            ->assertRedirect();

        $order = Order::firstOrFail();

        $response = $this->get(route('checkout.invoice', [
            'orderNumber' => $order->order_number,
            'accessToken' => 'invalid-token',
        ]));

        $response->assertNotFound();
    }
}