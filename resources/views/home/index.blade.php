@extends('layouts.app')

@section('title', 'CORE — Computer Hardware Store')
@section('meta_description', 'Temukan laptop, komponen PC, monitor, dan aksesori komputer di CORE.')

@push('styles')
<style>
    /* =========================
       CORE SILVER TECH
    ========================= */
    .core-home {
        --silver: #c6cbd2;
        --silver-light: #eef0f3;
        --graphite: #17191d;
        --graphite-soft: #22262c;
        --core-muted: #737b86;
        --core-border: #e3e6ea;
        color: #202329;
        overflow: hidden;
    }

    .core-home section[id] {
        scroll-margin-top: 85px;
    }

    /* HERO */
    .core-hero {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        color: #fff;
        background:
            radial-gradient(ellipse at 80% 45%, #444a53 0%, transparent 38%),
            linear-gradient(115deg, #111317 0%, #20242a 58%, #343a42 100%);
    }

    .core-hero::before {
        content: "";
        position: absolute;
        z-index: -1;
        width: 430px;
        height: 430px;
        right: -120px;
        top: -190px;
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 50%;
        box-shadow:
            0 0 0 45px rgba(255,255,255,.025),
            0 0 0 95px rgba(255,255,255,.02);
    }

    .core-hero::after {
        content: "";
        position: absolute;
        z-index: -1;
        inset: auto 0 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, #aeb5bf, transparent);
        opacity: .65;
    }

    .core-hero-inner {
        min-height: 430px;
        padding-top: 76px;
        padding-bottom: 76px;
        display: flex;
        align-items: center;
    }

    .core-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: #bfc5ce;
        font-size: .75rem;
        font-weight: 700;
        letter-spacing: .2em;
        text-transform: uppercase;
    }

    .core-eyebrow::before {
        content: "";
        width: 26px;
        height: 1px;
        background: #c6cbd2;
    }

    .core-hero-title {
        max-width: 720px;
        margin: 20px 0;
        font-size: clamp(2.6rem, 5vw, 4.6rem);
        line-height: 1.04;
        letter-spacing: -.055em;
        font-weight: 800;
    }

    .core-metal-text {
        color: #d9dde3;
        background: linear-gradient(110deg, #fff 10%, #a8afb9 45%, #f7f8fa 70%, #929aa5 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .core-hero-description {
        max-width: 560px;
        color: #c2c7cf;
        font-size: 1.08rem;
        line-height: 1.8;
    }

    .core-btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        min-height: 48px;
        padding: 12px 22px;
        border: 1px solid #f4f5f7;
        border-radius: 8px;
        background: linear-gradient(135deg, #fff, #c6cbd2);
        color: #17191d;
        font-weight: 700;
        text-decoration: none;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .core-btn-primary:hover {
        color: #111317;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,.2);
    }

    .core-btn-outline {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 48px;
        padding: 12px 22px;
        border: 1px solid #69717c;
        border-radius: 8px;
        color: #f2f4f7;
        font-weight: 600;
        text-decoration: none;
        transition: background .2s ease, border-color .2s ease;
    }

    .core-btn-outline:hover {
        color: #fff;
        border-color: #c6cbd2;
        background: rgba(255,255,255,.08);
    }

    .core-hero-visual {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 280px;
    }

    .core-visual-ring {
        position: absolute;
        width: min(29vw, 330px);
        aspect-ratio: 1;
        border: 1px solid rgba(220,225,232,.22);
        border-radius: 50%;
        box-shadow: 0 0 0 30px rgba(255,255,255,.025);
    }

    .core-visual-mark {
        position: relative;
        color: rgba(240,243,247,.9);
        font-size: clamp(8rem, 17vw, 15rem);
        line-height: 1;
        font-weight: 900;
        letter-spacing: -.1em;
        text-shadow: 0 16px 50px rgba(0,0,0,.4);
    }

    .core-visual-caption {
        position: absolute;
        right: 0;
        bottom: 8px;
        color: #c3c9d1;
        font-size: .7rem;
        letter-spacing: .2em;
        text-transform: uppercase;
    }

    /* SECTION HEADINGS */
    .core-section {
        padding-top: 68px;
        padding-bottom: 68px;
    }

    .core-section-heading {
        margin: 8px 0;
        font-size: clamp(1.7rem, 3vw, 2.3rem);
        font-weight: 800;
        letter-spacing: -.035em;
    }

    .core-section-description {
        color: var(--core-muted);
        margin-bottom: 0;
    }

    .core-section-kicker {
        color: #727a85;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
    }

    /* CATEGORY */
    .core-category-section {
        background: #f5f6f8;
    }

    .core-category-card {
        display: flex;
        align-items: center;
        gap: 16px;
        height: 100%;
        min-height: 142px;
        padding: 18px;
        overflow: hidden;
        border: 1px solid #e4e7eb;
        border-radius: 14px;
        background: #fff;
        color: #202329;
        text-decoration: none;
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }

    .core-category-card:hover {
        color: #202329;
        border-color: #b5bbc4;
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(25,30,38,.07);
    }

    .core-category-icon {
        display: flex;
        flex: 0 0 94px;
        align-items: center;
        justify-content: center;
        width: 94px;
        height: 94px;
        border-radius: 11px;
        background: linear-gradient(145deg, #f6f7f9, #e6e9ed);
        color: #414750;
    }

    .core-category-icon svg {
        width: 42px;
        height: 42px;
    }

    .core-category-name {
        margin-bottom: 7px;
        font-size: 1rem;
        font-weight: 750;
    }

    .core-category-description {
        display: -webkit-box;
        overflow: hidden;
        color: var(--core-muted);
        font-size: .84rem;
        line-height: 1.55;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .core-category-arrow {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        margin-top: 8px;
        border-radius: 50%;
        background: #f0f2f4;
        color: #303640;
        transition: background .2s ease;
    }

    .core-category-card:hover .core-category-arrow {
        background: #dfe3e8;
    }

    /* FILTERS */
    .core-filter-panel {
        padding: 18px;
        border: 1px solid var(--core-border);
        border-radius: 12px;
        background: #fff;
    }

    .core-filter-panel .form-control,
    .core-filter-panel .form-select {
        min-height: 46px;
        border-color: #dfe3e8;
        border-radius: 8px;
        font-size: .9rem;
    }

    .core-filter-panel .form-control:focus,
    .core-filter-panel .form-select:focus {
        border-color: #8e97a3;
        box-shadow: 0 0 0 .2rem rgba(100,110,125,.13);
    }

    .core-filter-button {
        min-height: 46px;
        border: 1px solid #202329;
        border-radius: 8px;
        background: #202329;
        color: #fff;
        font-weight: 600;
    }

    .core-filter-button:hover {
        background: #373d46;
        color: #fff;
    }

    .core-reset-link {
        color: #5d6570;
        font-size: .85rem;
        text-decoration: none;
    }

    .core-reset-link:hover {
        color: #111317;
        text-decoration: underline;
    }

    
    /* ========================================
    PRODUCT CARDS — CLEAN SILVER TECH
    ======================================== */

    .core-home .core-product-card {
        position: relative;
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow: hidden;

        background: #fff;
        border: 1px solid #e2e5e9;
        border-radius: 12px;

        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .core-home .core-product-card:hover {
        border-color: #bfc5cd;
        box-shadow: 0 8px 24px rgba(17, 19, 21, 0.07);
        transform: none;
    }

    /* Product image */

    .core-home .core-product-image-wrap {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;

        padding: 16px;
        background: #f7f8fa;
        border-bottom: 1px solid #edf0f3;
    }

    .core-home .core-product-image {
        display: block;
        width: 100%;
        height: 190px;
        object-fit: contain;
        mix-blend-mode: normal;
    }

    /* Discount badge */

    .core-home .core-product-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        z-index: 1;

        padding: 4px 8px;
    border: 1px solid #d9dde2;
        border-radius: 6px;

        background: #dc2626;
        color: #fff;
        border: 1px solid #dc2626;

        font-size: 0.7rem;
        font-weight: 700;
    }

    /* Product information */

    .core-home .core-product-body {
        display: flex;
        flex: 1;
        flex-direction: column;
        padding: 16px;
    }

    .core-home .core-product-category {
        margin-bottom: 7px;
        color: #737982;
        font-size: 0.76rem;
        font-weight: 500;
    }

    .core-home .core-product-name {
        display: -webkit-box;
        min-height: 2.8em;
        margin-bottom: 8px;
        overflow: hidden;

        color: #202328;
        font-size: 0.96rem;
        font-weight: 700;
        line-height: 1.4;

        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .core-home .core-product-description {
        display: -webkit-box;
        min-height: 2.9em;
        margin-bottom: 16px;
        overflow: hidden;

        color: #737982;
        font-size: 0.8rem;
        line-height: 1.5;

        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    /* Price */

    .core-home .core-product-old-price {
        margin-bottom: 3px;
        color: #858b94;
        font-size: 0.8rem;
        text-decoration: line-through;
    }

    .core-home .core-product-price {
        margin-bottom: 0;
        color: #17191d;
        font-size: 1.08rem;
        font-weight: 750;
        line-height: 1.4;
        overflow-wrap: anywhere;
    }

    /* Stock */

    .core-home .core-stock {
        display: flex;
        align-items: center;
        gap: 7px;

        margin-top: 10px;
        margin-bottom: 0;

        color: #626a74;
        font-size: 0.76rem;
    }

    .core-home .core-stock-dot {
        flex-shrink: 0;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #718b7a;
    }

    .core-home .core-stock-out {
        color: #777d86;
    }

    .core-home .core-stock-out .core-stock-dot {
        background: #a0a5ad;
    }

    /* Detail button */

    .core-home .core-product-footer {
        padding: 0 16px 16px;
    }

    .core-home .core-detail-button {
        display: flex;
        align-items: center;
        justify-content: center;

        width: 100%;
        min-height: 42px;
        padding: 10px 12px;

        border: 1px solid #252930;
        border-radius: 8px;

        background: #252930;
        color: #fff;

        font-size: 0.86rem;
        font-weight: 600;
        text-decoration: none;

        transition: background-color 0.2s ease;
    }

    .core-home .core-detail-button:hover {
        background: #414751;
        color: #fff;
    }

    /* Empty product state */

    .core-home .core-empty-state {
        padding: 48px 20px;
        border: 1px dashed #d1d5db;
        border-radius: 12px;
        background: #f8f9fb;
        text-align: center;
    }

    /* Responsive product cards */

    @media (max-width: 575.98px) {
        .core-home .core-product-image-wrap {
            padding: 12px;
        }

        .core-home .core-product-image {
            height: 145px;
        }

        .core-home .core-product-body {
            padding: 12px;
        }

        .core-home .core-product-footer {
            padding: 0 12px 12px;
        }

        .core-home .core-product-name {
            font-size: 0.87rem;
        }

        .core-home .core-product-description {
            font-size: 0.75rem;
        }

        .core-home .core-product-price {
            font-size: 0.96rem;
        }

        .core-home .core-product-badge {
            top: 7px;
            left: 7px;
            padding: 4px 6px;
            font-size: 0.64rem;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .core-home .core-product-card,
        .core-home .core-detail-button {
            transition: none;
        }
}


    /* LOCATION */
    .core-location {
        color: #fff;
        background: linear-gradient(120deg, #17191d, #2d333b);
    }

    .core-location .core-section-kicker {
        color: #c4cad2;
    }

    .core-location .core-section-description {
        color: #c2c7cf;
    }

    .core-location-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        margin-bottom: 18px;
        border: 1px solid #5d6570;
        border-radius: 14px;
        background: rgba(255,255,255,.06);
        color: #e0e4e9;
    }

    @media (max-width: 991.98px) {
        .core-hero-inner {
            min-height: auto;
            padding-top: 64px;
            padding-bottom: 64px;
        }

        .core-hero-visual {
            min-height: 180px;
        }

        .core-visual-ring {
            width: 190px;
        }

        .core-visual-mark {
            font-size: 9rem;
        }

        .core-visual-caption {
            right: 10%;
        }

        .core-category-card {
            gap: 12px;
            padding: 14px;
        }

        .core-category-icon {
            flex-basis: 70px;
            width: 70px;
            height: 78px;
        }

        .core-category-icon svg {
            width: 34px;
            height: 34px;
        }
    }

    @media (max-width: 575.98px) {
        .core-hero-inner {
            padding-top: 48px;
            padding-bottom: 42px;
        }

        .core-hero-title {
            font-size: clamp(2.45rem, 11vw, 3.5rem);
        }

        .core-hero-description {
            font-size: .98rem;
        }

        .core-hero-actions {
            display: grid;
            grid-template-columns: 1fr;
        }

        .core-hero-actions a {
            width: 100%;
        }

        .core-hero-visual {
            min-height: 135px;
        }

        .core-visual-ring {
            width: 135px;
        }

        .core-visual-mark {
            font-size: 6.5rem;
        }

        .core-visual-caption {
            right: 5%;
            bottom: 0;
            font-size: .58rem;
        }

        .core-section {
            padding-top: 46px;
            padding-bottom: 46px;
        }

        .core-category-card {
            min-height: 145px;
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
            padding: 12px;
        }

        .core-category-icon {
            flex-basis: auto;
            width: 100%;
            height: 85px;
        }

        .core-category-name {
            font-size: .9rem;
        }

        .core-category-description {
            font-size: .76rem;
        }

        .core-category-arrow {
            display: none;
        }

        .core-product-image {
            height: 145px;
        }

        .core-product-body {
            padding: 12px;
        }

        .core-product-footer {
            padding: 0 12px 12px;
        }

        .core-product-name {
            min-height: 40px;
            font-size: .88rem;
        }

        .core-product-description {
            font-size: .75rem;
        }

        .core-product-price {
            font-size: 1rem;
        }

        .core-product-badge {
            top: 7px;
            left: 7px;
            padding: 4px 6px;
            font-size: .64rem;
        }

        .core-filter-panel {
            padding: 13px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .core-home *,
        .core-home *::before,
        .core-home *::after {
            transition: none !important;
            animation: none !important;
        }
    }


    /* Hilangkan jarak kosong sebelum footer */
    .core-location {
        margin-bottom: 0 !important;
    }

    .core-home {
        margin-bottom: 0 !important;
    }

    body:has(.core-home) footer {
        margin-top: 0 !important;
    }
</style>
@endpush

@section('content')
<div class="core-home">
    {{-- HERO SECTION --}}
    <section class="core-hero">
        <div class="container">
            <div class="row align-items-center g-4 core-hero-inner">
                <div class="col-12 col-lg-7">
                    <span class="core-eyebrow">
                        Computer Hardware Store
                    </span>

                    <h1 class="core-hero-title">
                        Welcome to
                        <span class="core-metal-text">CORE.</span>
                    </h1>

                    <p class="core-hero-description">
                        Temukan berbagai kebutuhan hardware komputer
                        untuk produktivitas, kuliah, dan gaming.
                        Pilih perangkat yang tepat untuk setup kamu.
                    </p>

                    <div class="core-hero-actions d-flex flex-wrap gap-3 mt-4">
                        <a href="#produk" class="core-btn-primary">
                            Jelajahi Produk <span aria-hidden="true">→</span>
                        </a>

                        <a href="#kategori" class="core-btn-outline">
                            Lihat Kategori
                        </a>
                    </div>
                </div>

                <div class="core-hero-visual">
                <div class="core-visual-ring"></div>
                <img
                    src="{{ asset('images/logo-core.png') }}"
                    alt="Logo CORE"
                    class="core-hero-logo"
                >
            </div>
            </div>
        </div>
    </section>

    {{-- CATEGORY SECTION --}}
    <section class="core-category-section core-section" id="kategori">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
                <div>
                    <span class="core-section-kicker">Explore CORE</span>
                    <h2 class="core-section-heading">Belanja Berdasarkan Kategori</h2>
                    <p class="core-section-description">
                        Temukan perangkat sesuai kebutuhanmu.
                    </p>
                </div>

                <a href="#produk" class="core-reset-link">
                    Lihat semua produk →
                </a>
            </div>

            <div class="row g-3">
                @forelse ($categories as $category)
                    <div class="col-6 col-lg-3">
                        <a
                            href="{{ route('home', ['category' => $category->slug]) }}#produk"
                            class="core-category-card"
                        >
                            <div class="core-category-icon" aria-hidden="true">
                                @if (str_contains(strtolower($category->name), 'laptop'))
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <rect x="5" y="4" width="14" height="13" rx="1.5"/>
                                        <path d="M2.5 20h19l-2-3H4.5l-2 3Z"/>
                                    </svg>
                                @elseif (str_contains(strtolower($category->name), 'monitor'))
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <rect x="3" y="4" width="18" height="13" rx="1.5"/>
                                        <path d="M12 17v3m-4 0h8"/>
                                    </svg>
                                @elseif (str_contains(strtolower($category->name), 'komponen'))
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <rect x="4" y="4" width="16" height="16" rx="2"/>
                                        <rect x="8" y="8" width="8" height="8" rx="1"/>
                                        <path d="M9 1v3m6-3v3M9 20v3m6-3v3M1 9h3m-3 6h3m16-6h3m-3 6h3"/>
                                    </svg>
                                @else
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <rect x="3" y="7" width="18" height="12" rx="2"/>
                                        <path d="M7 7V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2M7 12h.01M11 12h.01M15 12h.01M19 12h.01"/>
                                    </svg>
                                @endif
                            </div>

                            <div class="flex-grow-1">
                                <h3 class="core-category-name">
                                    {{ $category->name }}
                                </h3>

                                <p class="core-category-description mb-0">
                                    {{ $category->description ?: 'Temukan produk pilihan di kategori ini.' }}
                                </p>

                                <span class="core-category-arrow" aria-hidden="true">
                                    →
                                </span>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="core-empty-state">
                            <p class="mb-0 text-secondary">
                                Belum ada kategori produk.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- PRODUCT SECTION --}}
    <section class="core-section bg-white" id="produk">
        <div class="container">
            <div class="mb-4">
                <span class="core-section-kicker">Discover your next upgrade</span>
                <h2 class="core-section-heading">Produk Unggulan</h2>
                <p class="core-section-description">
                    Berbagai kebutuhan hardware komputer dalam satu tempat.
                </p>
            </div>

            {{-- Search and filters --}}
            <form
                action="{{ route('home') }}"
                method="GET"
                class="core-filter-panel row g-3 mb-4"
            >
                <div class="col-12 col-md-5">
                    <label for="core-search" class="form-label small fw-semibold">
                        Cari produk
                    </label>
                    <input
                        id="core-search"
                        type="search"
                        name="search"
                        class="form-control"
                        placeholder="Laptop, monitor, keyboard..."
                        value="{{ request('search') }}"
                    >
                </div>

                <div class="col-6 col-md-3">
                    <label for="core-category" class="form-label small fw-semibold">
                        Kategori
                    </label>
                    <select id="core-category" name="category" class="form-select">
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
                    <label for="core-sort" class="form-label small fw-semibold">
                        Urutkan
                    </label>
                    <select id="core-sort" name="sort" class="form-select">
                        <option value="">Terbaru</option>
                        <option
                            value="price_asc"
                            {{ request('sort') === 'price_asc' ? 'selected' : '' }}
                        >
                            Harga termurah
                        </option>
                        <option
                            value="price_desc"
                            {{ request('sort') === 'price_desc' ? 'selected' : '' }}
                        >
                            Harga termahal
                        </option>
                    </select>
                </div>

                <div class="col-12 col-md-2 d-flex align-items-end">
                    <button type="submit" class="core-filter-button w-100">
                        Cari Produk
                    </button>
                </div>

                @if (request()->hasAny(['search', 'category', 'sort']))
                    <div class="col-12">
                        <a href="{{ route('home') }}" class="core-reset-link">
                            ← Reset pencarian dan filter
                        </a>
                    </div>
                @endif
            </form>

            {{-- Product grid --}}
            <div class="row g-3 g-lg-4">
                @forelse ($products as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        <article class="core-product-card">
                            <div class="core-product-image-wrap">
                                @if ($product->discount_active && $product->discount_percentage > 0)
                                    <span class="core-product-badge">
                                        Diskon
                                        {{ rtrim(rtrim(number_format($product->discount_percentage, 2, '.', ''), '0'), '.') }}%
                                    </span>
                                @endif

                                <img
                                    src="{{ $product->image_url ?: 'https://placehold.co/600x400/F0F2F5/59616D?text=CORE+Product' }}"
                                    class="core-product-image"
                                    alt="{{ $product->name }}"
                                    loading="lazy"
                                >
                            </div>

                            <div class="core-product-body">
                                <p class="core-product-category">
                                    {{ $product->category->name ?? 'Tanpa kategori' }}
                                </p>

                                <h3 class="core-product-name">
                                    {{ $product->name }}
                                </h3>

                                <p class="core-product-description">
                                    {{ $product->description ?: 'Produk hardware komputer pilihan dari CORE.' }}
                                </p>

                                <div class="mt-auto">
                                    @if ($product->discount_active && $product->discount_percentage > 0)
                                        <p class="core-product-old-price">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </p>

                                        <p class="core-product-price">
                                            Rp {{ number_format($product->discounted_price, 0, ',', '.') }}
                                        </p>
                                    @else
                                        <p class="core-product-price">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </p>
                                    @endif

                                    @if ($product->stock > 0)
                                        <p class="core-stock mb-0">
                                            <span class="core-stock-dot"></span>
                                            Stok tersedia: {{ $product->stock }}
                                        </p>
                                    @else
                                        <p class="core-stock core-stock-out mb-0">
                                            <span class="core-stock-dot"></span>
                                            Stok habis
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div class="core-product-footer">
                                <a
                                    href="{{ route('products.show', $product->slug) }}"
                                    class="core-detail-button"
                                >
                                    Lihat Detail <span class="ms-2" aria-hidden="true">→</span>
                                </a>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="core-empty-state">
                            <h3 class="h5 fw-bold">Produk belum ditemukan</h3>
                            <p class="text-secondary mb-3">
                                Coba kata kunci atau filter yang berbeda.
                            </p>
                            <a href="{{ route('home') }}" class="core-detail-button mx-auto" style="max-width: 220px;">
                                Tampilkan Semua Produk
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- STORE LOCATION --}}
    <section class="core-location core-section" id="lokasi">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-12 col-md-8">
                    <span class="core-section-kicker">Visit CORE</span>
                    <h2 class="core-section-heading">Temukan CORE Lebih Dekat</h2>
                    <p class="core-section-description">
                        Informasi lokasi dan layanan toko akan membantu kamu
                        menemukan kebutuhan hardware komputer.
                    </p>
                </div>

                <div class="col-12 col-md-4 text-md-end">
                    <div class="core-location-icon" aria-hidden="true">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.5">
                            <path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"/>
                            <circle cx="12" cy="10" r="2.5"/>
                        </svg>
                    </div>
                    <div class="text-start">
                        <p class="small text-white-50 mb-2">
                            <strong>Alamat Toko CORE</strong>
                        </p>

                        <p class="small text-white-50 mb-3">
                            Jl. Margonda Raya No. 100, Pondok Cina,
                            Kecamatan Beji, Kota Depok, Jawa Barat 16424
                        </p>

                        <p class="small text-white-50 mb-3">
                            Jam operasional: Senin – Sabtu, 09.00 – 20.00 WIB
                        </p>

                        <a
                            href="https://maps.app.goo.gl/CqyiLS13sY4DoE8XA"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="btn btn-light btn-sm">
                            <i class="bi bi-geo-alt"></i>
                            Petunjuk Arah
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection