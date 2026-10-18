@extends('layouts.app')

@section('title', 'Keranjang Belanja | CORE')

@section('content')

<style>
    .core-cart-page {
        --cart-dark: #23272e;
        --cart-muted: #788391;
        --cart-border: #e2e6ec;
        --cart-surface: #f5f6f8;
        padding-top: 48px !important;
        padding-bottom: 64px !important;
        color: var(--cart-dark);
    }

    .core-cart-page .cart-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 12px;
        color: #788391;
        font-size: .72rem;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .core-cart-page .cart-eyebrow::before {
        width: 23px;
        height: 2px;
        background: #87919e;
        content: "";
    }

    .core-cart-page .cart-heading {
        margin-bottom: 10px;
        font-size: clamp(2rem, 4vw, 2.8rem);
        font-weight: 800;
        letter-spacing: -1.3px;
    }

    .core-cart-page .cart-subheading {
        color: var(--cart-muted);
        font-size: .98rem;
        line-height: 1.7;
    }

    .core-cart-page .cart-section-heading {
        margin: 0;
        font-size: 1.08rem;
        font-weight: 800;
    }

    .core-cart-page .cart-product {
        margin-bottom: 18px !important;
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--cart-border) !important;
        border-radius: 16px;
        box-shadow: 0 5px 22px rgba(35, 39, 46, .035) !important;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .core-cart-page .cart-product:hover {
        border-color: #c5ccd5 !important;
        box-shadow: 0 10px 28px rgba(35, 39, 46, .07) !important;
    }

    .core-cart-page .cart-product .card-body {
        padding: 21px;
    }

    .core-cart-page .cart-image-wrap {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 155px;
        padding: 12px;
        overflow: hidden;
        background: var(--cart-surface);
        border: 1px solid #edf0f3;
        border-radius: 12px;
    }

    .core-cart-page .cart-product-image {
        display: block;
        width: 100%;
        height: 130px;
        object-fit: contain;
        transition: transform .25s ease;
    }

    .core-cart-page .cart-product:hover .cart-product-image {
        transform: scale(1.04);
    }

    .core-cart-page .cart-product-name {
        margin-bottom: 10px;
        font-size: 1.05rem;
        font-weight: 750;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .core-cart-page .cart-price-current {
        margin-bottom: 8px;
        color: var(--cart-dark);
        font-size: 1.08rem;
        font-weight: 800;
    }

    .core-cart-page .cart-stock {
        color: var(--cart-muted);
        font-size: .82rem;
    }

    .core-cart-page .cart-quantity-form {
        margin-top: 14px !important;
    }

    .core-cart-page .cart-quantity-input {
        width: 82px !important;
        min-height: 40px;
        border: 1px solid #d9dfe7;
        border-radius: 9px;
        font-weight: 700;
    }

    .core-cart-page .cart-quantity-input:focus {
        border-color: #788391;
        box-shadow: 0 0 0 3px rgba(120, 131, 145, .13);
    }

    .core-cart-page .cart-remove-button {
        padding: 6px 0;
        border: 0;
        font-size: .84rem;
        text-decoration: none;
    }

    .core-cart-page .cart-remove-button:hover {
        text-decoration: underline;
    }

    .core-cart-page .cart-subtotal {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 15px;
        padding-top: 14px;
        border-top: 1px solid #edf0f3;
        font-size: .88rem;
    }

    .core-cart-page .cart-subtotal strong {
        font-size: .98rem;
    }

    .core-cart-page .cart-summary {
        position: sticky;
        top: 24px;
        overflow: hidden;
        border: 1px solid var(--cart-border) !important;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(35, 39, 46, .055) !important;
    }

    .core-cart-page .cart-summary .card-body {
        padding: 25px;
    }

    .core-cart-page .cart-summary-title {
        margin-bottom: 6px;
        font-size: 1.2rem;
        font-weight: 800;
    }

    .core-cart-page .cart-summary-caption {
        margin-bottom: 23px;
        color: var(--cart-muted);
        font-size: .84rem;
        line-height: 1.6;
    }

    .core-cart-page .cart-summary-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-top: 17px;
        color: #626d7b;
        font-size: .9rem;
    }

    .core-cart-page .cart-summary-row strong {
        color: var(--cart-dark);
    }

    .core-cart-page .cart-summary-total {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-top: 22px;
        padding-top: 19px;
        border-top: 1px solid var(--cart-border);
    }

    .core-cart-page .cart-summary-total-label {
        font-size: .9rem;
        font-weight: 700;
    }

    .core-cart-page .cart-summary-total-value {
        font-size: 1.25rem;
        font-weight: 850;
        text-align: right;
        overflow-wrap: anywhere;
    }

    .core-cart-page .cart-checkout-button {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        min-height: 51px;
        margin-top: 23px !important;
        padding: 13px 16px;
        color: #fff;
        background: var(--cart-dark);
        border: 1px solid var(--cart-dark);
        border-radius: 10px;
        font-size: .92rem;
        font-weight: 750;
        text-decoration: none;
        transition: background .2s ease, transform .2s ease;
    }

    .core-cart-page .cart-checkout-button:hover:not(.disabled) {
        color: #fff;
        background: #3b424d;
        transform: translateY(-1px);
    }

    .core-cart-page .cart-checkout-button.disabled {
        opacity: .55;
        cursor: not-allowed;
        pointer-events: none;
    }

    .core-cart-page .cart-continue-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 13px;
        padding: 10px 0;
        color: #626d7b;
        border: 0;
        font-size: .88rem;
        text-decoration: none;
    }

    .core-cart-page .cart-continue-button:hover {
        color: var(--cart-dark);
    }

    .core-cart-page .cart-security-note {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-top: 19px;
        padding: 13px;
        color: #697482;
        background: var(--cart-surface);
        border: 1px solid #edf0f3;
        border-radius: 10px;
        font-size: .78rem;
        line-height: 1.65;
    }

    .core-cart-page .cart-security-note svg {
        flex-shrink: 0;
        margin-top: 1px;
    }

    .core-cart-page .cart-empty {
        padding: 60px 22px;
        background:
            radial-gradient(circle at 50% 0%, #f0f2f5, transparent 65%),
            #fff;
        border: 1px solid var(--cart-border);
        border-radius: 18px;
        text-align: center;
    }

    .core-cart-page .cart-empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 82px;
        height: 82px;
        margin: 0 auto 24px;
        color: #525d6b;
        background: #edf0f4;
        border: 1px solid #e0e5eb;
        border-radius: 23px;
    }

    .core-cart-page .cart-empty h2 {
        margin-bottom: 10px;
        font-size: clamp(1.4rem, 3vw, 1.8rem);
        font-weight: 800;
        letter-spacing: -.5px;
    }

    .core-cart-page .cart-empty p {
        margin-bottom: 23px;
        color: var(--cart-muted);
    }

    .core-cart-page .cart-shop-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        min-height: 47px;
        padding: 12px 22px;
        color: #fff;
        background: var(--cart-dark);
        border: 1px solid var(--cart-dark);
        border-radius: 10px;
        font-weight: 700;
        text-decoration: none;
        transition: background .2s ease, transform .2s ease;
    }

    .core-cart-page .cart-shop-button:hover {
        color: #fff;
        background: #3b424d;
        transform: translateY(-1px);
    }

    .core-cart-page .cart-feedback {
        border-radius: 11px;
    }

    .core-cart-page .cart-message {
        overflow-wrap: anywhere;
        line-height: 1.6;
    }

    @media (max-width: 991.98px) {
        .core-cart-page .cart-summary {
            position: static;
        }
    }

    @media (max-width: 575.98px) {
        .core-cart-page {
            padding-top: 30px !important;
            padding-bottom: 40px !important;
        }

        .core-cart-page .cart-product .card-body {
            padding: 14px;
        }

        .core-cart-page .cart-image-wrap {
            min-height: 100px;
            padding: 7px;
        }

        .core-cart-page .cart-product-image {
            height: 88px;
        }

        .core-cart-page .cart-product-name {
            font-size: .96rem;
        }

        .core-cart-page .cart-summary .card-body {
            padding: 20px;
        }

        .core-cart-page .cart-empty {
            padding: 42px 18px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .core-cart-page *,
        .core-cart-page *::before,
        .core-cart-page *::after {
            transition-duration: .01ms !important;
        }
    }
</style>

<div class="container core-cart-page">

    <div class="mb-4">
        <div class="cart-eyebrow">CORE / YOUR SELECTION</div>

        <h1 class="cart-heading">Keranjang Belanja</h1>

        <p class="cart-subheading mb-0">
            Periksa produk pilihanmu sebelum melanjutkan.
        </p>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show cart-feedback"
             role="alert">
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Tutup"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show cart-feedback"
             role="alert">
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Tutup"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger cart-feedback" role="alert">
            {{ $errors->first() }}
        </div>
    @endif

    @if (empty($cart))
        {{-- EMPTY CART --}}
        <section class="cart-empty">

            <div class="cart-empty-icon" aria-hidden="true">
                <svg width="40"
                     height="40"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.5"
                     stroke-linecap="round"
                     stroke-linejoin="round">
                    <path d="M3 3h2l2.4 12.2a2 2 0 0 0 2 1.6h7.8a2 2 0 0 0 2-1.6L21 8H6"/>
                    <circle cx="10" cy="20" r="1"/>
                    <circle cx="18" cy="20" r="1"/>
                </svg>
            </div>

            <div class="cart-eyebrow">CORE STORE</div>

            <h2>Keranjangmu masih kosong</h2>

            <p>
                Temukan hardware yang cocok untuk kebutuhanmu.
            </p>

            <a href="{{ route('home') }}" class="cart-shop-button">
                <svg width="18"
                     height="18"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.8"
                     stroke-linecap="round"
                     stroke-linejoin="round"
                     aria-hidden="true">
                    <path d="M5 12h14M13 6l6 6-6 6"/>
                </svg>

                Mulai Belanja
            </a>
        </section>

    @else

        <div class="row g-4 cart-layout">

            {{-- DAFTAR PRODUK --}}
            <div class="col-lg-8" id="cart-items">

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h2 class="cart-section-heading">Produk Pilihanmu</h2>

                    <span class="small text-secondary">
                        {{ count($cart) }} jenis produk
                    </span>
                </div>

                @foreach ($cart as $productId => $quantity)

                    @php
                        $product = $products->get((int) $productId);

                        $quantity = filter_var(
                            $quantity,
                            FILTER_VALIDATE_INT,
                            ['options' => ['min_range' => 1]]
                        );
                    @endphp

                    @if ($product && $quantity !== false)

                        @php
                            $price = (float) $product->discounted_price;
                            $subtotal = $price * $quantity;
                        @endphp

                        <article
                            class="card cart-product"
                            data-cart-item
                            data-price="{{ $price }}"
                            data-stock="{{ $product->stock }}"
                        >
                            <div class="card-body">

                                <div class="row align-items-start g-3">

                                    {{-- GAMBAR PRODUK --}}
                                    <div class="col-4 col-md-4 col-xl-3">
                                        <div class="cart-image-wrap">
                                            <img
                                                src="{{ $product->image_url ?: 'https://placehold.co/300x200?text=CORE' }}"
                                                alt="{{ $product->name }}"
                                                class="cart-product-image"
                                                loading="lazy"
                                            >
                                        </div>
                                    </div>

                                    {{-- DETAIL PRODUK --}}
                                    <div class="col-8 col-md-8 col-xl-9">

                                        <h3 class="cart-product-name">
                                            {{ $product->name }}
                                        </h3>

                                        @if (
                                            $product->discount_active &&
                                            $product->discount_percentage > 0
                                        )
                                            <p class="text-secondary text-decoration-line-through small mb-1">
                                                Rp {{ number_format((float) $product->price, 0, ',', '.') }}
                                            </p>

                                            <p class="cart-price-current mb-2">
                                                Rp {{ number_format($price, 0, ',', '.') }}
                                            </p>
                                        @else
                                            <p class="cart-price-current mb-2">
                                                Rp {{ number_format($price, 0, ',', '.') }}
                                            </p>
                                        @endif

                                        <p class="cart-stock mb-2">
                                            <svg width="15"
                                                 height="15"
                                                 viewBox="0 0 24 24"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 stroke-width="1.7"
                                                 stroke-linecap="round"
                                                 stroke-linejoin="round"
                                                 aria-hidden="true"
                                                 style="vertical-align:-2px;">
                                                <path d="m5 12 4 4L19 6"/>
                                            </svg>

                                            Stok tersedia: {{ $product->stock }}
                                        </p>

                                        {{-- UBAH JUMLAH: ROUTE DAN DATA DIPERTAHANKAN --}}
                                        <form
                                            action="{{ route('cart.update', $product->id) }}"
                                            method="POST"
                                            data-quantity-form
                                            class="cart-quantity-form d-flex align-items-center flex-wrap gap-2"
                                        >
                                            @csrf

                                            <label
                                                for="quantity-{{ $product->id }}"
                                                class="small fw-semibold"
                                            >
                                                Jumlah
                                            </label>

                                            <input
                                                type="number"
                                                id="quantity-{{ $product->id }}"
                                                name="quantity"
                                                value="{{ $quantity }}"
                                                min="1"
                                                max="{{ $product->stock }}"
                                                step="1"
                                                data-quantity
                                                data-saved-value="{{ $quantity }}"
                                                class="form-control form-control-sm text-center cart-quantity-input"
                                                required
                                                @disabled($product->stock < 1)
                                            >

                                            <span
                                                data-saving
                                                class="small text-secondary"
                                                aria-live="polite"
                                            ></span>
                                        </form>

                                        {{-- HAPUS PRODUK --}}
                                        <form
                                            action="{{ route('cart.remove', $product->id) }}"
                                            method="POST"
                                            class="mt-2"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-link text-danger cart-remove-button"
                                                onclick="return confirm('Hapus produk ini dari keranjang?')"
                                            >
                                                <svg width="15"
                                                     height="15"
                                                     viewBox="0 0 24 24"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     stroke-width="1.8"
                                                     stroke-linecap="round"
                                                     stroke-linejoin="round"
                                                     aria-hidden="true"
                                                     style="vertical-align:-2px;">
                                                    <path d="M3 6h18"/>
                                                    <path d="M8 6V4h8v2"/>
                                                    <path d="m19 6-1 14H6L5 6"/>
                                                    <path d="M10 11v5M14 11v5"/>
                                                </svg>

                                                Hapus produk
                                            </button>
                                        </form>

                                        {{-- SUBTOTAL --}}
                                        <div class="cart-subtotal">
                                            <span class="text-secondary">
                                                Subtotal produk
                                            </span>

                                            <strong data-subtotal>
                                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                                            </strong>
                                        </div>

                                        @if ($product->stock < 1)
                                            <p class="text-danger small mt-2 mb-0">
                                                Produk sedang habis. Hapus produk ini untuk melanjutkan.
                                            </p>
                                        @elseif ($quantity > $product->stock)
                                            <p class="text-danger small mt-2 mb-0">
                                                Jumlah melebihi stok tersedia.
                                            </p>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </article>

                    @endif
                @endforeach

                <a href="{{ route('home') }}" class="cart-continue-button">
                    <svg width="17"
                         height="17"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8"
                         stroke-linecap="round"
                         stroke-linejoin="round"
                         aria-hidden="true">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>

                    Lanjut belanja
                </a>

            </div>

            {{-- RINGKASAN BELANJA --}}
            <div class="col-lg-4">

                <aside class="card cart-summary">
                    <div class="card-body">

                        <h2 class="cart-summary-title">
                            Ringkasan Belanja
                        </h2>

                        <p class="cart-summary-caption">
                            Periksa jumlah dan total produk sebelum checkout.
                        </p>

                        <div class="cart-summary-row">
                            <span>Jumlah barang</span>

                            <strong>
                                <span id="cart-count">0</span> item
                            </strong>
                        </div>

                        <div class="cart-summary-total">
                            <span class="cart-summary-total-label">
                                Total belanja
                            </span>

                            <strong
                                id="cart-total"
                                class="cart-summary-total-value"
                            >
                                Rp 0
                            </strong>
                        </div>

                        <a
                            href="{{ route('checkout.index') }}"
                            class="cart-checkout-button"
                            id="checkout-button"
                        >
                            Lanjut ke Checkout

                            <svg width="18"
                                 height="18"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8"
                                 stroke-linecap="round"
                                 stroke-linejoin="round"
                                 aria-hidden="true">
                                <path d="M5 12h14M13 6l6 6-6 6"/>
                            </svg>
                        </a>

                        <p
                            id="cart-message"
                            class="small text-secondary mt-3 mb-0 cart-message"
                            aria-live="polite"
                        ></p>

                        <div class="cart-security-note">
                            <svg width="19"
                                 height="19"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.7"
                                 stroke-linecap="round"
                                 stroke-linejoin="round"
                                 aria-hidden="true">
                                <path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11Z"/>
                                <path d="m9 12 2 2 4-4"/>
                            </svg>

                            <span>
                                Pastikan jumlah barang sudah sesuai sebelum melanjutkan ke checkout.
                            </span>
                        </div>

                    </div>
                </aside>

            </div>

        </div>
    @endif

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const money = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0
    });

    const totalElement = document.getElementById('cart-total');
    const countElement = document.getElementById('cart-count');
    const messageElement = document.getElementById('cart-message');
    const checkoutButton = document.getElementById('checkout-button');

    if (!totalElement || !countElement || !messageElement) {
        return;
    }

    // Hitung total dan jumlah barang berdasarkan nilai input.
    function updateTotals() {
        let total = 0;
        let count = 0;
        let invalid = false;

        document.querySelectorAll('[data-cart-item]').forEach(function (item) {
            const input = item.querySelector('[data-quantity]');
            const subtotalElement = item.querySelector('[data-subtotal]');

            if (!input || !subtotalElement) {
                return;
            }

            const price = Number(item.dataset.price);
            const stock = Number(item.dataset.stock);
            const quantity = Number(input.value);

            const valid =
                Number.isInteger(quantity) &&
                quantity >= 1 &&
                quantity <= stock;

            input.setCustomValidity(
                valid ? '' : 'Masukkan jumlah yang valid sesuai stok.'
            );

            if (!valid) {
                invalid = true;
                subtotalElement.textContent = '—';
                return;
            }

            subtotalElement.textContent = money.format(price * quantity);

            total += price * quantity;
            count += quantity;
        });

        totalElement.textContent = money.format(total);
        countElement.textContent = count;

        if (checkoutButton) {
            const disabled = count === 0 || invalid;

            checkoutButton.classList.toggle('disabled', disabled);
            checkoutButton.setAttribute(
                'aria-disabled',
                disabled ? 'true' : 'false'
            );
        }
    }

    // Simpan perubahan kuantitas ke session Laravel.
    async function saveQuantity(form, input) {
        const item = form.closest('[data-cart-item]');
        const status = form.querySelector('[data-saving]');
        const previousValue = input.dataset.savedValue;
        const quantity = Number(input.value);
        const stock = Number(item.dataset.stock);

        if (
            !Number.isInteger(quantity) ||
            quantity < 1 ||
            quantity > stock
        ) {
            input.value = previousValue;
            status.textContent = 'Jumlah tidak valid.';
            updateTotals();
            return;
        }

        if (String(quantity) === String(previousValue)) {
            return;
        }

        // Buat FormData sebelum input dinonaktifkan.
        const formData = new FormData(form);
        formData.set('quantity', String(quantity));

        input.disabled = true;
        status.textContent = 'Menyimpan...';
        messageElement.textContent = '';

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData,
                credentials: 'same-origin'
            });

            const result = await response.json().catch(function () {
                return {};
            });

            if (!response.ok || result.success !== true) {
                const errorMessage = result.errors
                    ? Object.values(result.errors).flat().join(' ')
                    : result.message;

                throw new Error(
                    errorMessage ||
                    'Gagal menyimpan perubahan. Silakan coba lagi.'
                );
            }

            input.dataset.savedValue = String(result.quantity);
            input.value = String(result.quantity);

            status.textContent = 'Tersimpan';
            messageElement.textContent =
                'Jumlah produk berhasil diperbarui.';

        } catch (error) {
            input.value = previousValue;

            status.textContent = 'Gagal menyimpan';
            messageElement.textContent = error.message;

            console.error('Gagal memperbarui keranjang:', error);

        } finally {
            input.disabled = false;
            updateTotals();
        }
    }

    document.querySelectorAll('[data-quantity-form]').forEach(function (form) {
        const input = form.querySelector('[data-quantity]');
        if (!input) {
            return;
        }

        input.addEventListener('input', function () {
            statusMessage(form, '');
            updateTotals();
        });

        input.addEventListener('change', function () {
            saveQuantity(form, input);
        });

        input.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                saveQuantity(form, input);
            }
        });

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            saveQuantity(form, input);
        });
    });

    function statusMessage(form, message) {
        const status = form.querySelector('[data-saving]');

        if (status) {
            status.textContent = message;
        }
    }

    // Cegah checkout jika perubahan kuantitas belum tersimpan.
    if (checkoutButton) {
        checkoutButton.addEventListener('click', function (event) {
            const unsaved = Array.from(
                document.querySelectorAll('[data-quantity]')
            ).some(function (input) {
                return (
                    input.value !== input.dataset.savedValue ||
                    input.disabled
                );
            });

            if (
                unsaved ||
                checkoutButton.getAttribute('aria-disabled') === 'true'
            ) {
                event.preventDefault();

                messageElement.textContent = unsaved
                    ? 'Tunggu sampai perubahan jumlah tersimpan.'
                    : 'Periksa jumlah produk sebelum checkout.';
            }
        });
    }

    updateTotals();
});
</script>

@endsection