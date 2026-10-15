@extends('layouts.app')

@section('title', 'Keranjang Belanja - CORE')

@section('content')
<div class="container py-5">

    <h1 class="fw-bold mb-2">Keranjang Belanja</h1>
    <p class="text-secondary mb-4">
        Periksa produk pilihanmu sebelum melanjutkan.
    </p>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (count($cart) === 0)
        <div class="text-center py-5 border rounded">
            <h4>Keranjang masih kosong</h4>
            <p class="text-secondary">
                Yuk, pilih produk yang kamu butuhkan.
            </p>
            <a href="{{ route('home') }}" class="btn btn-dark">
                Belanja Sekarang
            </a>
        </div>
    @else
        <div class="row g-4">
            <div class="col-lg-8">
                @foreach ($cart as $productId => $quantity)
                    @if (isset($products[$productId]))
                        @php
                            $product = $products[$productId];
                            $price = $product->discount_active
                                && $product->discount_percentage > 0
                                ? $product->discounted_price
                                : $product->price;
                        @endphp

                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                                <div class="row align-items-center g-3">
                                    <div class="col-4 col-md-3">
                                        <img
                                            src="{{ $product->image_url ?: 'https://placehold.co/300x200?text=CORE' }}"
                                            alt="{{ $product->name }}"
                                            class="img-fluid rounded"
                                        >
                                    </div>

                                    <div class="col-8 col-md-9">
                                        <h5 class="fw-bold">
                                            {{ $product->name }}
                                        </h5>

                                        <p class="mb-1">
                                            Rp {{ number_format($price, 0, ',', '.') }}
                                        </p>

                                        <p class="text-secondary mb-0"> 
                                        <form action="{{ route('cart.update', $productId) }}"
                                            method="POST"
                                            class="d-flex align-items-center gap-2 mt-2">
                                            @csrf

                                            <label for="quantity-{{ $productId }}" class="small">
                                                Jumlah:
                                            </label>

                                            <button
                                                type="submit"
                                                class="btn btn-outline-dark btn-sm"
                                                onclick="this.form.quantity.stepDown()"
                                                {{ $quantity <= 1 ? 'disabled' : '' }}
                                            >
                                                −
                                            </button>

                                            <input
                                                type="number"
                                                id="quantity-{{ $productId }}"
                                                name="quantity"
                                                value="{{ $quantity }}"
                                                min="1"
                                                max="{{ $product->stock }}"
                                                class="form-control form-control-sm text-center"
                                                style="width: 65px;"
                                                required
                                            >

                                            <button
                                                type="submit"
                                                class="btn btn-outline-dark btn-sm"
                                                onclick="this.form.quantity.stepUp()"
                                                {{ $quantity >= $product->stock ? 'disabled' : '' }}
                                            >
                                                +
                                            </button>
                                        </form>

                                        <form action="{{ route('cart.remove', $productId) }}"
                                            method="POST"
                                            class="mt-2">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                Hapus produk
                                            </button>
                                        </form>
                                        </p>

                                        <p class="fw-bold mt-2 mb-0">
                                            Subtotal: Rp {{ number_format($price * $quantity, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

                <a href="{{ route('home') }}"
                   class="btn btn-outline-dark">
                    &larr; Lanjut Belanja
                </a>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold">Ringkasan Belanja</h5>

                        <div class="d-flex justify-content-between mt-3">
                            <span>Total</span>
                            <strong>
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </strong>
                        </div>

                        <button
                            type="button"
                            class="btn btn-dark w-100 mt-4"
                            disabled
                        >
                            Checkout — segera hadir
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection