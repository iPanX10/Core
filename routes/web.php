<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\CheckoutController;

Route::get('/', function (Request $request) {
    $query = Product::with('category');

    // Pencarian berdasarkan nama produk
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
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

Route::get('/produk/{slug}', function ($slug) {
    $product = \App\Models\Product::with('category')
        ->where('slug', $slug)
        ->firstOrFail();

    return view('products.show', compact('product'));
})->name('products.show');

// Menampilkan isi keranjang
Route::get('/keranjang', function () {
    $cart = Session::get('cart', []);

    $products = \App\Models\Product::whereIn(
        'id',
        array_keys($cart)
    )->get()->keyBy('id');

    $total = 0;

    foreach ($cart as $productId => $quantity) {
        if (isset($products[$productId])) {
            $total += $products[$productId]->discount_active
                && $products[$productId]->discount_percentage > 0
                ? $products[$productId]->discounted_price * $quantity
                : $products[$productId]->price * $quantity;
        }
    }

    return view('cart.index', compact('cart', 'products', 'total'));
})->name('cart.index');

// Menambahkan produk ke keranjang
Route::post('/keranjang/tambah/{id}', function ($id) {
    $product = \App\Models\Product::findOrFail($id);

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

// Halaman checkout
Route::get('/checkout', [CheckoutController::class, 'index'])
    ->name('checkout.index');

// Memproses pesanan
Route::post('/checkout', [CheckoutController::class, 'store'])
    ->name('checkout.store');

// Konfirmasi pesanan
Route::get('/pesanan/{orderNumber}', [CheckoutController::class, 'success'])
    ->name('checkout.success');