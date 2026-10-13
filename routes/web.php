<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Category;

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