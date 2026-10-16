<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    // Menampilkan halaman checkout
    public function index()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang kamu masih kosong.');
        }

        $products = Product::whereIn('id', array_keys($cart))
            ->get()
            ->keyBy('id');

        $total = 0;

        foreach ($cart as $productId => $quantity) {
            if (!isset($products[$productId])) {
                continue;
            }

            $product = $products[$productId];
            $price = $product->discounted_price;

            $total += round($price * $quantity, 2);
        }

        return view('checkout.index', compact(
            'cart',
            'products',
            'total'
        ));
    }

    // Memproses checkout
    public function store(Request $request)
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang kamu masih kosong.');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'whatsapp' => [
                'required',
                'string',
                'max:20',
                'regex:/^[0-9+\-\s()]+$/',
            ],
            'fulfillment_method' => 'required|in:delivery,pickup',
            'address' => 'required_if:fulfillment_method,delivery|nullable|string|max:2000',
            'payment_method' => 'required|in:bank_transfer,qris,ewallet',
        ], [
            'customer_name.required' => 'Nama pembeli wajib diisi.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'whatsapp.regex' => 'Format nomor WhatsApp tidak valid.',
            'fulfillment_method.required' => 'Pilih metode penerimaan pesanan.',
            'address.required_if' => 'Alamat wajib diisi untuk pengiriman.',
            'payment_method.required' => 'Pilih metode pembayaran.',
        ]);

        $order = DB::transaction(function () use ($cart, $validated) {
            $productIds = array_map('intval', array_keys($cart));
            sort($productIds);

            $products = Product::whereIn('id', $productIds)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $total = 0;
            $items = [];

            foreach ($cart as $productId => $quantity) {
                $product = $products->get((int) $productId);
                $quantity = filter_var(
                    $quantity,
                    FILTER_VALIDATE_INT,
                    ['options' => ['min_range' => 1]]
                );

                if (!$product || !$quantity) {
                    throw ValidationException::withMessages([
                        'cart' => 'Data keranjang tidak valid. Silakan periksa kembali.',
                    ]);
                }

                if ($product->stock < $quantity) {
                    throw ValidationException::withMessages([
                        'cart' => "Stok {$product->name} tidak mencukupi. Stok tersedia: {$product->stock}.",
                    ]);
                }

                $unitPrice = round($product->discounted_price, 2);
                $subtotal = round($unitPrice * $quantity, 2);
                $total += $subtotal;

                $items[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ];
            }

            $order = Order::create([
                'order_number' => 'CORE-' . Str::upper(Str::random(10)),
                'access_token' => Str::random(64),
                'customer_name' => $validated['customer_name'],
                'whatsapp' => $validated['whatsapp'],
                'fulfillment_method' => $validated['fulfillment_method'],
                'address' => $validated['fulfillment_method'] === 'delivery'
                    ? $validated['address']
                    : null,
                'payment_method' => $validated['payment_method'],
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'total' => $total,
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'product_name' => $item['product']->name,
                    'unit_price' => $item['unit_price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);

                $item['product']->decrement('stock', $item['quantity']);
            }

            return $order;
        });

        Session::forget('cart');

        return redirect()->route('checkout.success', [
            'orderNumber' => $order->order_number,
            'accessToken' => $order->access_token,
        ]);
    }

    // Menampilkan konfirmasi pesanan
    public function success(string $orderNumber, string $accessToken)
    {
        $order = Order::with('items')
            ->where('order_number', $orderNumber)
            ->where('access_token', $accessToken)
            ->firstOrFail();

        return view('checkout.success', compact('order'));
    }

    public function invoice(string $orderNumber, string $accessToken)
    {
        $order = \App\Models\Order::with('items')
            ->where('order_number', $orderNumber)
            ->where('access_token', $accessToken)
            ->firstOrFail();

        return view('checkout.invoice', compact('order'));
    }
}