<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Category;

Route::get('/', function () {
    $products = Product::with('category')
        ->latest()
        ->get();

    $categories = Category::orderBy('name')->get();

    return view('home.index', compact('products', 'categories'));
})->name('home');