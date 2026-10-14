@extends('layouts.app')

@section('title', $product->name . ' - CORE')

@section('content')
<div class="container py-5">
    <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
        &larr; Kembali ke katalog
    </a>

    <div class="row g-5 mt-2">
        <div class="col-md-6">
            <img
                src="{{ $product->image_url ?: 'https://placehold.co/600x400?text=CORE+Product' }}"
                alt="{{ $product->name }}"
                class="img-fluid rounded shadow-sm w-100"
                style="max-height: 450px; object-fit: contain;"
            >
        </div>

        <div class="col-md-6">
            <p class="text-secondary">
                {{ $product->category->name ?? 'Tanpa kategori' }}
            </p>

            <h1 class="fw-bold">{{ $product->name }}</h1>

            <p class="text-secondary mt-3">
                {{ $product->description }}
            </p>

            @if ($product->discount_active && $product->discount_percentage > 0)
                <p class="text-secondary text-decoration-line-through mb-0">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>

                <h2 class="text-danger fw-bold">
                    Rp {{ number_format($product->discounted_price, 0, ',', '.') }}
                </h2>

                <span class="badge bg-danger mb-3">
                    Diskon {{ rtrim(rtrim(number_format($product->discount_percentage, 2, '.', ''), '0'), '.') }}%
                </span>
            @else
                <h2 class="fw-bold">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </h2>
            @endif

            <p class="{{ $product->stock > 0 ? 'text-success' : 'text-danger' }}">
                {{ $product->stock > 0 ? 'Stok tersedia: ' . $product->stock : 'Stok habis' }}
            </p>

            <button
                type="button"
                class="btn btn-dark btn-lg w-100 mt-3"
                disabled
            >
                Keranjang — segera hadir
            </button>
        </div>
    </div>
</div>
@endsection