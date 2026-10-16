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

    // Pencarian berdasarkan nama produk
    if ($request->filled('search')) {
        $query->where(
            'name',
            'like',
            '%' . $request->search . '%'
        );
    }

    // Filter berdasarkan kategori
    if ($request->filled('category')) {
        $query->whereHas('category', function ($categoryQuery) use ($request) {
            $categoryQuery->where('slug', $request->category);
        });
    }

    // Pengurutan harga
    if ($request->sort === 'price_asc') {
        $query->orderBy('price', 'asc');
    } elseif ($request->sort === 'price_desc') {
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

Route::get('/produk/{slug}', function ($slug) {
    $product = Product::with('category')
        ->where('slug', $slug)
        ->firstOrFail();

    return view('products.show', compact('product'));
})->name('products.show');


// ==================================================
// KERANJANG BELANJA
// ==================================================

// Menampilkan isi keranjang
Route::get('/keranjang', function () {
    $cart = Session::get('cart', []);

    $products = Product::whereIn(
        'id',
        array_keys($cart)
    )->get()->keyBy('id');

    $total = 0;

    foreach ($cart as $productId => $quantity) {
        if (isset($products[$productId])) {
            $product = $products[$productId];

            $price = $product->discount_active
                && $product->discount_percentage > 0
                ? $product->discounted_price
                : $product->price;

            $total += $price * $quantity;
        }
    }

    return view('cart.index', compact('cart', 'products', 'total'));
})->name('cart.index');


// Menambahkan produk ke keranjang
Route::post('/keranjang/tambah/{id}', function ($id) {
    $product = Product::findOrFail($id);

    if ($product->stock < 1) {
        return back()->with('error', 'Produk sedang habis.');
    }

    $cart = Session::get('cart', []);
    $quantity = ($cart[$id] ?? 0) + 1;

    if ($quantity > $product->stock) {
        return back()->with('error', 'Jumlah melebihi stok tersedia.');
    }

    $cart[$id] = $quantity;
    Session::put('cart', $cart);

    return redirect()->route('cart.index')
        ->with('success', 'Produk berhasil ditambahkan ke keranjang.');
})->name('cart.add');


// Mengubah jumlah produk di keranjang
Route::post('/keranjang/ubah/{id}', function (Request $request, $id) {
    $product = Product::findOrFail($id);

    $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    $quantity = (int) $request->quantity;

    if ($quantity > $product->stock) {
        return back()->with(
            'error',
            'Jumlah melebihi stok tersedia: ' . $product->stock
        );
    }

    $cart = session('cart', []);

    if (!array_key_exists($id, $cart)) {
        return back()->with('error', 'Produk tidak ada di keranjang.');
    }

    $cart[$id] = $quantity;
    session(['cart' => $cart]);

    return redirect()->route('cart.index')
        ->with('success', 'Jumlah produk berhasil diperbarui.');
})->name('cart.update');


// Menghapus produk dari keranjang
Route::delete('/keranjang/hapus/{id}', function ($id) {
    $cart = session('cart', []);

    if (!array_key_exists($id, $cart)) {
        return back()->with('error', 'Produk tidak ada di keranjang.');
    }

    unset($cart[$id]);
    session(['cart' => $cart]);

    return redirect()->route('cart.index')
        ->with('success', 'Produk berhasil dihapus dari keranjang.');
})->name('cart.remove');


// ==================================================
// CHECKOUT
// ==================================================

// Halaman checkout
Route::get('/checkout', [CheckoutController::class, 'index'])
    ->name('checkout.index');

// Memproses pesanan
Route::post('/checkout', [CheckoutController::class, 'store'])
    ->name('checkout.store');


// ==================================================
// DETAIL DAN PELACAKAN PESANAN
// ==================================================

// Halaman konfirmasi dan pelacakan pesanan
Route::get('/pesanan/{orderNumber}/{accessToken}', [
    CheckoutController::class,
    'success'
])->name('checkout.success');


// ==================================================
// INVOICE PESANAN
// ==================================================

// Halaman invoice pesanan
Route::get('/pesanan/{orderNumber}/{accessToken}/invoice', [
    CheckoutController::class,
    'invoice'
])->name('checkout.invoice');


// ==================================================
// RIWAYAT PESANAN
// ==================================================

// Form pencarian riwayat pesanan
Route::get('/riwayat-pesanan', function () {
    return view('orders.history');
})->name('orders.history');


// Pencarian pesanan berdasarkan nomor pesanan dan WhatsApp
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

    // Pesanan tidak ditemukan
    if (! $order) {
        return back()
            ->withInput()
            ->withErrors([
                'order_number' => 'Pesanan tidak ditemukan. Periksa kembali nomor pesanan dan WhatsApp.',
            ]);
    }

    // Menampilkan ringkasan pesanan
    return view('orders.result', compact('order'));

})->middleware('throttle:5,1')->name('orders.history.search');