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
    /**
     * Menampilkan halaman checkout.
     */
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

    /**
     * Memproses checkout dan menyimpan pesanan.
     */
    public function store(Request $request)
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang kamu masih kosong.');
        }

        // Validasi data pembeli dan metode pembayaran.
        $validated = $request->validate([
            'customer_name' => [
                'required',
                'string',
                'max:255',
            ],

            'whatsapp' => [
                'required',
                'string',
                'max:20',
                'regex:/^[0-9+\-\s()]+$/',
            ],

            'fulfillment_method' => [
                'required',
                'in:delivery,pickup',
            ],

            'address' => [
                'required_if:fulfillment_method,delivery',
                'nullable',
                'string',
                'max:2000',
            ],

            'payment_method' => [
                'required',
                'in:bank_transfer,qris,ewallet',
            ],

            'payment_provider' => [
                'required',
                'string',
                'in:bni,bri,mandiri,bca,qris,dana,gopay,ovo,shopeepay',
            ],
        ], [
            'customer_name.required' =>
                'Nama pembeli wajib diisi.',

            'whatsapp.required' =>
                'Nomor WhatsApp wajib diisi.',

            'whatsapp.regex' =>
                'Format nomor WhatsApp tidak valid.',

            'fulfillment_method.required' =>
                'Pilih metode penerimaan pesanan.',

            'address.required_if' =>
                'Alamat wajib diisi untuk pengiriman.',

            'payment_method.required' =>
                'Pilih metode pembayaran.',

            'payment_provider.required' =>
                'Pilih bank atau penyedia pembayaran.',

            'payment_provider.in' =>
                'Penyedia pembayaran tidak valid.',
        ]);

        // Memastikan penyedia pembayaran sesuai metode yang dipilih.
        $allowedProviders = [
            'bank_transfer' => [
                'bni',
                'bri',
                'mandiri',
                'bca',
            ],

            'qris' => [
                'qris',
            ],

            'ewallet' => [
                'dana',
                'gopay',
                'ovo',
                'shopeepay',
            ],
        ];

        if (!in_array(
            $validated['payment_provider'],
            $allowedProviders[$validated['payment_method']],
            true
        )) {
            throw ValidationException::withMessages([
                'payment_provider' =>
                    'Penyedia pembayaran tidak sesuai dengan metode yang dipilih.',
            ]);
        }

        // Membuat pesanan dalam transaksi database.
        $order = DB::transaction(function () use (
            $cart,
            $validated
        ) {
            $productIds = array_map(
                'intval',
                array_keys($cart)
            );

            sort($productIds);

            // Mengunci data produk selama proses checkout.
            $products = Product::whereIn('id', $productIds)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $total = 0;
            $items = [];

            // Memeriksa stok dan menghitung harga pesanan.
            foreach ($cart as $productId => $quantity) {
                $product = $products->get((int) $productId);

                $quantity = filter_var(
                    $quantity,
                    FILTER_VALIDATE_INT,
                    ['options' => ['min_range' => 1]]
                );

                if (!$product || !$quantity) {
                    throw ValidationException::withMessages([
                        'cart' =>
                            'Data keranjang tidak valid. Silakan periksa kembali.',
                    ]);
                }

                if ($product->stock < $quantity) {
                    throw ValidationException::withMessages([
                        'cart' =>
                            "Stok {$product->name} tidak mencukupi. "
                            . "Stok tersedia: {$product->stock}.",
                    ]);
                }

                $unitPrice = round(
                    $product->discounted_price,
                    2
                );

                $subtotal = round(
                    $unitPrice * $quantity,
                    2
                );

                $total += $subtotal;

                $items[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ];
            }

            /*
             * Menentukan informasi pembayaran.
             *
             * Transfer bank:
             * Nomor VA simulasi dibuat sekali saat checkout.
             *
             * E-wallet:
             * Menggunakan nomor yang ditentukan untuk simulasi.
             *
             * QRIS:
             * Belum menggunakan kode QR resmi.
             */
            $paymentAccountNumber = null;
            $paymentAccountName = null;

            if ($validated['payment_method'] === 'bank_transfer') {
                $paymentAccountNumber = '880'
                    . (string) random_int(
                        1000000000,
                        9999999999
                    );

                $paymentAccountName = 'CORE';
            } elseif ($validated['payment_method'] === 'ewallet') {
                $paymentAccountNumber = '085123300335';
                $paymentAccountName = 'CORE';
            }

            // Menyimpan informasi pesanan.
            $order = Order::create([
                'order_number' =>
                    'CORE-' . Str::upper(Str::random(10)),

                'access_token' => Str::random(64),

                'customer_name' =>
                    $validated['customer_name'],

                'whatsapp' =>
                    $validated['whatsapp'],

                'fulfillment_method' =>
                    $validated['fulfillment_method'],

                'address' =>
                    $validated['fulfillment_method'] === 'delivery'
                        ? $validated['address']
                        : null,

                'payment_method' =>
                    $validated['payment_method'],

                'payment_provider' =>
                    $validated['payment_provider'],

                'payment_account_number' =>
                    $paymentAccountNumber,

                'payment_account_name' =>
                    $paymentAccountName,

                'status' => 'pending',

                'payment_status' => 'unpaid',

                'total' => $total,
            ]);

            // Menyimpan detail item dan mengurangi stok.
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,

                    'product_id' =>
                        $item['product']->id,

                    'product_name' =>
                        $item['product']->name,

                    'unit_price' =>
                        $item['unit_price'],

                    'quantity' =>
                        $item['quantity'],

                    'subtotal' =>
                        $item['subtotal'],
                ]);

                $item['product']->decrement(
                    'stock',
                    $item['quantity']
                );
            }

            return $order;
        });

        // Keranjang dikosongkan setelah transaksi berhasil.
        Session::forget('cart');

        // Mengarahkan pembeli ke halaman konfirmasi pesanan.
        return redirect()->route('checkout.success', [
            'orderNumber' => $order->order_number,
            'accessToken' => $order->access_token,
        ]);
    }

    /**
     * Menampilkan konfirmasi pesanan dan instruksi pembayaran.
     */
    public function success(
        string $orderNumber,
        string $accessToken
    ) {
        $order = Order::with('items')
            ->where('order_number', $orderNumber)
            ->where('access_token', $accessToken)
            ->firstOrFail();

        $paymentMethodLabels = [
            'bank_transfer' => 'Transfer Bank / Virtual Account',
            'qris' => 'QRIS',
            'ewallet' => 'E-Wallet',
        ];

        $paymentProviderLabels = [
            'bni' => 'BNI',
            'bri' => 'BRI',
            'mandiri' => 'Mandiri',
            'bca' => 'BCA',
            'qris' => 'QRIS',
            'dana' => 'DANA',
            'gopay' => 'GoPay',
            'ovo' => 'OVO',
            'shopeepay' => 'ShopeePay',
        ];

        return view('checkout.success', compact(
            'order',
            'paymentMethodLabels',
            'paymentProviderLabels'
        ));
    }

    /**
     * Menampilkan invoice pesanan.
     */
    public function invoice(
        string $orderNumber,
        string $accessToken
    ) {
        $order = Order::with('items')
            ->where('order_number', $orderNumber)
            ->where('access_token', $accessToken)
            ->firstOrFail();

        $paymentMethodLabels = [
            'bank_transfer' => 'Transfer Bank / Virtual Account',
            'qris' => 'QRIS',
            'ewallet' => 'E-Wallet',
        ];

        $paymentProviderLabels = [
            'bni' => 'BNI',
            'bri' => 'BRI',
            'mandiri' => 'Mandiri',
            'bca' => 'BCA',
            'qris' => 'QRIS',
            'dana' => 'DANA',
            'gopay' => 'GoPay',
            'ovo' => 'OVO',
            'shopeepay' => 'ShopeePay',
        ];

        return view('checkout.invoice', compact(
            'order',
            'paymentMethodLabels',
            'paymentProviderLabels'
        ));
    }
}