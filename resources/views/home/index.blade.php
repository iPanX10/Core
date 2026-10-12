@extends('layouts.app')

@section('title', 'CORE - Computer Hardware Store')

@section('content')

<section class="bg-light py-5">
    <div class="container py-5 text-center">
        <h1 class="display-4 fw-bold">
            Welcome to CORE
        </h1>

        <p class="lead mt-3">
            Temukan hardware komputer yang sesuai dengan kebutuhanmu.
        </p>

        <a href="#produk" class="btn btn-dark btn-lg mt-3">
            Jelajahi Produk
        </a>
    </div>
</section>

<section class="container py-5" id="produk">
    <div class="text-center mb-4">
        <h2 class="fw-bold">Produk Unggulan</h2>
        <p class="text-secondary">
            Berbagai kebutuhan hardware komputer dalam satu tempat.
        </p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Laptop</h5>
                    <p class="card-text">
                        Temukan laptop untuk belajar, bekerja, dan gaming.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Monitor</h5>
                    <p class="card-text">
                        Pilihan monitor untuk produktivitas dan hiburan.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Accessories</h5>
                    <p class="card-text">
                        Keyboard, mouse, dan aksesoris komputer lainnya.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-light py-5" id="lokasi">
    <div class="container text-center">
        <h2 class="fw-bold">Lokasi Toko</h2>
        <p class="text-secondary">
            Informasi lokasi toko akan ditampilkan di sini.
        </p>
    </div>
</section>

@endsection