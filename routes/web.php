<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Http\Controllers\CheckoutController;

// ==================================================
// HALAMAN UTAMA
// ==================================================

Route::get('/', function (Request $request) {
    $query = Product::with('category');

    // Pencarian produk
    if ($request->filled('search')) {
        $search = trim((string) $request->input('search'));

        $query->where('name', 'like', '%' . $search . '%');
    }

    // Filter kategori
    if ($request->filled('category')) {
        $query->whereHas('category', function ($q) use ($request) {
            $q->where('slug', $request->input('category'));
        });
    }

    // Pengurutan produk
    if ($request->input('sort') === 'price_asc') {
        $query->orderBy('price', 'asc');
    } elseif ($request->input('sort') === 'price_desc') {
        $query->orderBy('price', 'desc');
    } else {
        $query->latest();
    }

    $products = $query->get();
    $categories = Category::orderBy('name')->get();

    return view('home.index', compact('products', 'categories'));
})->name('home');


// ==================================================
// DETAIL PRODUK
// ==================================================

Route::get('/produk/{slug}', function (string $slug) {
    $product = Product::with('category')
        ->where('slug', $slug)
        ->firstOrFail();

    return view('products.show', compact('product'));
})->name('products.show');


// ==================================================
// MENAMPILKAN KERANJANG
// ==================================================

Route::get('/keranjang', function () {
    $cart = Session::get('cart', []);

    if (!is_array($cart)) {
        $cart = [];
    }

    // Validasi ID dan jumlah produk.
    $validCart = [];

    foreach ($cart as $productId => $quantity) {
        $id = filter_var($productId, FILTER_VALIDATE_INT);
        $qty = filter_var($quantity, FILTER_VALIDATE_INT);

        if (
            $id === false ||
            $id < 1 ||
            $qty === false ||
            $qty < 1
        ) {
            continue;
        }

        $validCart[$id] = ($validCart[$id] ?? 0) + $qty;
    }

    // Ambil seluruh produk dalam keranjang.
    $products = Product::with('category')
        ->whereIn('id', array_keys($validCart))
        ->get()
        ->keyBy('id');

    $cartForView = [];
    $total = 0;
    $itemCount = 0;

    foreach ($validCart as $productId => $quantity) {
        $product = $products->get((int) $productId);

        if (!$product || $product->stock < 1) {
            continue;
        }

        // Batasi jumlah sesuai stok terbaru.
        $quantity = min($quantity, (int) $product->stock);

        if ($quantity < 1) {
            continue;
        }

        $cartForView[(int) $productId] = $quantity;

        // Samakan accessor harga dengan CheckoutController.
        $price = (float) $product->discounted_price;

        $total += $price * $quantity;
        $itemCount += $quantity;
    }

    // Simpan keranjang yang sudah divalidasi.
    Session::put('cart', $cartForView);

    return view('cart.index', [
        'cart' => $cartForView,
        'products' => $products,
        'total' => $total,
        'itemCount' => $itemCount,
    ]);
})->name('cart.index');


// ==================================================
// MENAMBAHKAN PRODUK KE KERANJANG
// ==================================================

Route::post('/keranjang/tambah/{id}', function (int $id) {
    $product = Product::findOrFail($id);

    if ($product->stock < 1) {
        return back()->with('error', 'Produk sedang habis.');
    }

    $cart = Session::get('cart', []);

    if (!is_array($cart)) {
        $cart = [];
    }

    $currentQuantity = filter_var(
        $cart[$id] ?? 0,
        FILTER_VALIDATE_INT
    );

    if ($currentQuantity === false || $currentQuantity < 0) {
        $currentQuantity = 0;
    }

    $newQuantity = $currentQuantity + 1;

    if ($newQuantity > $product->stock) {
        return back()->with(
            'error',
            'Jumlah melebihi stok tersedia: ' . $product->stock
        );
    }

    // Pertahankan produk lain di keranjang.
    $cart[$id] = $newQuantity;

    Session::put('cart', $cart);

    return redirect()
        ->route('cart.index')
        ->with('success', 'Produk berhasil ditambahkan ke keranjang.');
})->whereNumber('id')->name('cart.add');


// ==================================================
// MEMPERBARUI JUMLAH PRODUK - OTOMATIS DENGAN JSON
// ==================================================

Route::post('/keranjang/ubah/{id}', function (
    Request $request,
    int $id
) {
    // Validasi jumlah.
    $validated = $request->validate([
        'quantity' => ['required', 'integer', 'min:1'],
    ]);

    $cart = Session::get('cart', []);

    if (!is_array($cart) || !array_key_exists($id, $cart)) {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan di keranjang.',
            ], 404);
        }

        return back()->with(
            'error',
            'Produk tidak ditemukan di keranjang.'
        );
    }

    $product = Product::find($id);

    if (!$product) {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan.',
            ], 404);
        }

        return back()->with(
            'error',
            'Produk tidak ditemukan.'
        );
    }

    $quantity = (int) $validated['quantity'];

    // Periksa stok terbaru.
    if ($product->stock < 1 || $quantity > $product->stock) {
        $message = 'Jumlah melebihi stok tersedia atau produk sedang habis.';

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $message,
            ], 422);
        }

        return back()->with('error', $message);
    }

    // Ubah jumlah produk tanpa menghapus produk lain.
    $cart[$id] = $quantity;

    Session::put('cart', $cart);
    Session::save();

    // Respons JSON dibutuhkan oleh JavaScript cart.index.
    if ($request->expectsJson()) {
        return response()->json([
            'success' => true,
            'quantity' => $quantity,
            'message' => 'Jumlah produk berhasil diperbarui.',
        ]);
    }

    // Tetap mendukung pengiriman form biasa.
    return redirect()
        ->route('cart.index')
        ->with('success', 'Jumlah produk berhasil diperbarui.');
})->whereNumber('id')->name('cart.update');


// ==================================================
// MENGHAPUS PRODUK DARI KERANJANG
// ==================================================

Route::delete('/keranjang/hapus/{id}', function (int $id) {
    $cart = Session::get('cart', []);

    if (!is_array($cart) || !array_key_exists($id, $cart)) {
        return back()->with(
            'error',
            'Produk tidak ditemukan di keranjang.'
        );
    }

    unset($cart[$id]);

    Session::put('cart', $cart);

    return redirect()
        ->route('cart.index')
        ->with('success', 'Produk berhasil dihapus dari keranjang.');
})->whereNumber('id')->name('cart.remove');


// ==================================================
// CHECKOUT
// ==================================================

Route::get('/checkout', [
    CheckoutController::class,
    'index',
])->name('checkout.index');

Route::post('/checkout', [
    CheckoutController::class,
    'store',
])->name('checkout.store');


// ==================================================
// DETAIL PESANAN
// ==================================================

Route::get('/pesanan/{orderNumber}/{accessToken}', [
    CheckoutController::class,
    'success',
])->name('checkout.success');


// ==================================================
// INVOICE PESANAN
// ==================================================

Route::get('/pesanan/{orderNumber}/{accessToken}/invoice', [
    CheckoutController::class,
    'invoice',
])->name('checkout.invoice');


// ==================================================
// RIWAYAT PESANAN
// ==================================================

Route::get('/riwayat-pesanan', function () {
    return view('orders.history');
})->name('orders.history');


// ==================================================
// PENCARIAN RIWAYAT PESANAN
// ==================================================

Route::post('/riwayat-pesanan', function (Request $request) {
    $validated = $request->validate([
        'order_number' => ['required', 'string', 'max:50'],
        'whatsapp' => ['required', 'string', 'max:20'],
    ]);

    $order = Order::query()
        ->with('items')
        ->where(
            'order_number',
            strtoupper(trim($validated['order_number']))
        )
        ->where(
            'whatsapp',
            trim($validated['whatsapp'])
        )
        ->whereNotNull('access_token')
        ->where('access_token', '!=', '')
        ->first();

    if (!$order) {
        return back()
            ->withInput()
            ->withErrors([
                'order_number' =>
                    'Pesanan tidak ditemukan. Periksa kembali nomor pesanan dan WhatsApp.',
            ]);
    }

    return view('orders.result', compact('order'));
})->middleware('throttle:5,1')->name('orders.history.search');