@extends('layouts.app')

@section('title', 'CORE - Computer Hardware Store')

@section('content')

{{-- HERO SECTION --}}
<section class="bg-light py-5">
    <div class="container py-5 text-center">
        <h1 class="display-4 fw-bold">Welcome to CORE</h1>

        <p class="lead mt-3">
            Temukan hardware komputer yang sesuai dengan kebutuhanmu.
        </p>

        <a href="#produk" class="btn btn-dark btn-lg mt-3">
            Jelajahi Produk
        </a>
    </div>
</section>

{{-- CATEGORY SECTION --}}
<section class="container py-5" id="kategori">
    <div class="text-center mb-4">
        <h2 class="fw-bold">Kategori Produk</h2>
        <p class="text-secondary">
            Temukan perangkat sesuai kebutuhanmu.
        </p>
    </div>

    <div class="row g-4">
        @forelse ($categories as $category)
            <div class="col-6 col-md-3">
                <a href="#produk" class="text-decoration-none text-dark">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center py-4">
                            <h5 class="card-title fw-bold">
                                {{ $category->name }}
                            </h5>

                            <p class="card-text text-secondary small mb-0">
                                {{ $category->description }}
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <p class="text-center">Belum ada kategori produk.</p>
        @endforelse
    </div>
</section>

{{-- PRODUCT SECTION --}}
<section class="container py-5" id="produk">
    <div class="text-center mb-4">
        <h2 class="fw-bold">Produk Unggulan</h2>
        <p class="text-secondary">
            Berbagai kebutuhan hardware komputer dalam satu tempat.
        </p>
    </div>

<form action="{{ route('home') }}" method="GET" class="row g-2 mb-4">

    <div class="col-12 col-md-5">
        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Cari laptop, monitor, keyboard..."
            value="{{ request('search') }}"
        >
    </div>

    <div class="col-6 col-md-3">
        <select name="category" class="form-select">
            <option value="">Semua Kategori</option>

            @foreach ($categories as $category)
                <option
                    value="{{ $category->slug }}"
                    {{ request('category') === $category->slug ? 'selected' : '' }}
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-6 col-md-2">
        <select name="sort" class="form-select">
            <option value="">Terbaru</option>
            <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>
                Harga Termurah
            </option>
            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>
                Harga Termahal
            </option>
        </select>
    </div>

    <div class="col-12 col-md-2">
        <button type="submit" class="btn btn-dark w-100">
            Cari Produk
        </button>
    </div>

    @if (request()->hasAny(['search', 'category', 'sort']))
        <div class="col-12">
            <a href="{{ route('home') }}" class="text-secondary small">
                Reset pencarian dan filter
            </a>
        </div>
    @endif

</form>

    <div class="row g-4">
        @forelse ($products as $product)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm">

                    @if ($product->discount_active && $product->discount_percentage > 0)
                        <span class="badge bg-danger position-absolute m-2">
                            Diskon {{ rtrim(rtrim(number_format($product->discount_percentage, 2, '.', ''), '0'), '.') }}%
                        </span>
                    @endif

                    <img
                        src="{{ $product->image_url ?: 'https://placehold.co/600x400?text=CORE+Product' }}"
                        class="card-img-top"
                        alt="{{ $product->name }}"
                        style="height: 200px; object-fit: contain; padding: 12px;"
                        loading="lazy"
                    >

                    <div class="card-body d-flex flex-column">
                        <p class="small text-secondary mb-1">
                            {{ $product->category->name ?? 'Tanpa kategori' }}
                        </p>

                        <h5 class="card-title fs-6 fw-bold">
                            {{ $product->name }}
                        </h5>

                        <p class="card-text text-secondary small">
                            {{ $product->description }}
                        </p>

                        <div class="mt-auto">
                            @if ($product->discount_active && $product->discount_percentage > 0)
                                <p class="text-secondary small text-decoration-line-through mb-0">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>

                                <p class="text-danger fw-bold fs-5 mb-1">
                                    Rp {{ number_format($product->discounted_price, 0, ',', '.') }}
                                </p>
                            @else
                                <p class="fw-bold fs-5 mb-1">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            @endif

                            @if ($product->stock > 0)
                                <p class="small text-success mb-0">
                                    Stok: {{ $product->stock }}
                                </p>
                            @else
                                <p class="small text-danger mb-0">
                                    Stok habis
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="card-footer bg-white border-0 pb-3">
                        <button
                            type="button"
                            class="btn btn-dark w-100"
                            disabled
                            title="Fitur keranjang akan dibuat pada tahap berikutnya"
                        >
                            Segera Hadir
                        </button>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12 text-center py-4">
                <p class="text-secondary">
                    Belum ada produk yang tersedia.
                </p>
            </div>
        @endforelse
    </div>
</section>

{{-- STORE LOCATION --}}
<section class="bg-light py-5" id="lokasi">
    <div class="container text-center">
        <h2 class="fw-bold">Lokasi Toko</h2>
        <p class="text-secondary">
            Informasi lokasi toko akan ditampilkan di sini.
        </p>
    </div>
</section>

@endsection