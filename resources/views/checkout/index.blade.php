@extends('layouts.app')

@section('title', 'Checkout | CORE')

@section('content')
<style>
    .core-checkout {
        --cc-dark: #23272e;
        --cc-text: #292e35;
        --cc-muted: #788391;
        --cc-border: #e1e5eb;
        --cc-bg: #f6f7f9;
        padding-top: 42px;
        padding-bottom: 72px;
        color: var(--cc-text);
    }

    .core-checkout * {
        box-sizing: border-box;
    }

    .core-checkout .cc-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 10px;
        color: var(--cc-muted);
        font-size: .72rem;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .core-checkout .cc-eyebrow::before {
        width: 23px;
        height: 2px;
        background: #87919e;
        content: "";
    }

    .core-checkout .cc-title {
        margin: 0;
        font-size: clamp(2rem, 4vw, 2.65rem);
        font-weight: 850;
        letter-spacing: -1.3px;
    }

    .core-checkout .cc-subtitle {
        margin: 10px 0 0;
        color: var(--cc-muted);
        font-size: .96rem;
        line-height: 1.7;
    }

    .core-checkout .cc-steps {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 23px;
        margin-bottom: 30px;
        color: var(--cc-muted);
        font-size: .82rem;
    }

    .core-checkout .cc-step {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .core-checkout .cc-step-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 27px;
        height: 27px;
        border: 1px solid var(--cc-border);
        border-radius: 50%;
        font-size: .75rem;
        font-weight: 800;
    }

    .core-checkout .cc-step.active {
        color: var(--cc-dark);
        font-weight: 750;
    }

    .core-checkout .cc-step.active .cc-step-number {
        color: #fff;
        background: var(--cc-dark);
        border-color: var(--cc-dark);
    }

    .core-checkout .cc-step-line {
        width: 34px;
        height: 1px;
        background: var(--cc-border);
    }

    .core-checkout .cc-card {
        margin-bottom: 22px;
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--cc-border);
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(35, 39, 46, .035);
    }

    .core-checkout .cc-card-header {
        display: flex;
        align-items: flex-start;
        gap: 13px;
        padding: 22px 24px 0;
    }

    .core-checkout .cc-section-icon {
        display: inline-flex;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        color: #515c69;
        background: #f0f2f5;
        border: 1px solid #e7eaf0;
        border-radius: 11px;
    }

    .core-checkout .cc-section-title {
        margin: 0;
        font-size: 1.02rem;
        font-weight: 800;
    }

    .core-checkout .cc-section-description {
        margin: 5px 0 0;
        color: var(--cc-muted);
        font-size: .82rem;
        line-height: 1.6;
    }

    .core-checkout .cc-card-body {
        padding: 22px 24px 24px;
    }

    .core-checkout .cc-label {
        display: block;
        margin-bottom: 8px;
        color: #353b44;
        font-size: .88rem;
        font-weight: 700;
    }

    .core-checkout .cc-control {
        display: block;
        width: 100%;
        min-height: 47px;
        padding: 11px 13px;
        color: var(--cc-text);
        background: #fff;
        border: 1px solid #dce1e8;
        border-radius: 9px;
        font-size: .92rem;
        transition: border-color .18s, box-shadow .18s;
    }

    .core-checkout .cc-control::placeholder {
        color: #9aa3ae;
    }

    .core-checkout .cc-control:focus {
        border-color: #788391;
        outline: none;
        box-shadow: 0 0 0 3px rgba(120, 131, 145, .13);
    }

    .core-checkout textarea.cc-control {
        min-height: 108px;
        resize: vertical;
    }

    .core-checkout .cc-field {
        margin-bottom: 19px;
    }

    .core-checkout .cc-field:last-child {
        margin-bottom: 0;
    }

    .core-checkout .cc-help {
        display: block;
        margin-top: 7px;
        color: var(--cc-muted);
        font-size: .78rem;
        line-height: 1.6;
    }

    .core-checkout .cc-choice {
        position: relative;
        display: flex;
        align-items: flex-start;
        gap: 11px;
        padding: 15px;
        background: #fff;
        border: 1px solid var(--cc-border);
        border-radius: 11px;
        cursor: pointer;
        transition: border-color .18s, background .18s, box-shadow .18s;
    }

    .core-checkout .cc-choice:hover {
        border-color: #a9b1bc;
    }

    .core-checkout .cc-choice:has(.cc-radio:checked) {
        background: #f7f8fa;
        border-color: #737e8b;
        box-shadow: inset 0 0 0 1px #737e8b;
    }

    .core-checkout .cc-radio {
        flex-shrink: 0;
        width: 17px;
        height: 17px;
        margin: 3px 0 0;
        accent-color: #303741;
        cursor: pointer;
    }

    .core-checkout .cc-choice-title {
        display: block;
        font-size: .9rem;
        font-weight: 750;
        line-height: 1.5;
    }

    .core-checkout .cc-choice-description {
        display: block;
        margin-top: 4px;
        color: var(--cc-muted);
        font-size: .78rem;
        line-height: 1.5;
    }

    .core-checkout .cc-delivery-options {
        display: grid;
        gap: 10px;
    }

    .core-checkout .cc-payment-method {
        padding: 16px;
        background: #fff;
        border: 1px solid var(--cc-border);
        border-radius: 12px;
        transition: border-color .18s, background .18s;
    }

    .core-checkout .cc-payment-method.selected {
        background: #fbfbfc;
        border-color: #a3acb8;
    }

    .core-checkout .cc-payment-heading {
        display: flex;
        align-items: flex-start;
        gap: 11px;
    }

    .core-checkout .cc-payment-heading label {
        flex: 1;
        cursor: pointer;
    }

    .core-checkout .cc-payment-heading .badge {
        font-size: .68rem;
        font-weight: 700;
    }

    .core-checkout .cc-provider-section {
        display: none;
        margin-top: 17px;
        padding-top: 16px;
        border-top: 1px solid #e9ecf1;
    }

    .core-checkout .cc-provider-label {
        margin-bottom: 11px;
        color: var(--cc-muted);
        font-size: .8rem;
    }

    .core-checkout .cc-provider-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 9px;
    }

    .core-checkout .cc-provider-card {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
        min-height: 64px;
        padding: 10px;
        background: #fff;
        border: 1px solid var(--cc-border);
        border-radius: 10px;
        cursor: pointer;
        transition: border-color .18s, background .18s;
    }

    .core-checkout .cc-provider-card:hover {
        border-color: #9ca6b2;
    }

    .core-checkout .cc-provider-card:has(.cc-provider-input:checked) {
        background: #f3f5f7;
        border-color: #687381;
        box-shadow: inset 0 0 0 1px #687381;
    }

    .core-checkout .cc-provider-input {
        flex-shrink: 0;
        width: 16px;
        height: 16px;
        margin: 0;
        accent-color: #303741;
    }

    .core-checkout .cc-payment-logo {
        display: block;
        flex-shrink: 0;
        width: 64px;
        height: 34px;
        object-fit: contain;
        border: 1px solid #edf0f3;
        border-radius: 5px;
    }

    .core-checkout .cc-provider-name {
        min-width: 0;
        font-size: .85rem;
        font-weight: 750;
        overflow-wrap: anywhere;
    }

    .core-checkout .cc-qris-box {
        margin-top: 14px;
        padding: 19px;
        text-align: center;
        background: #f7f8fa;
        border: 1px dashed #cbd2dc;
        border-radius: 11px;
    }

    .core-checkout .cc-qris-image {
        display: block;
        width: 190px;
        max-width: 100%;
        height: auto;
        margin: 0 auto;
        background: #fff;
        border-radius: 7px;
    }

    .core-checkout .cc-qris-fallback {
        display: none;
        width: 150px;
        height: 150px;
        margin: 0 auto;
        padding: 10px;
        background: #fff;
        border: 1px solid #e1e5eb;
        border-radius: 8px;
    }

    .core-checkout .cc-fake-qr {
        display: grid;
        width: 100%;
        height: 100%;
        grid-template-columns: repeat(9, 1fr);
        gap: 3px;
    }

    .core-checkout .cc-fake-qr span {
        background: #303741;
    }

    .core-checkout .cc-fake-qr span:nth-child(3n),
    .core-checkout .cc-fake-qr span:nth-child(4n) {
        background: #fff;
        border: 1px solid #303741;
    }

    .core-checkout .cc-qris-warning {
        display: inline-block;
        margin-top: 11px;
        padding: 6px 9px;
        color: #9b3131;
        background: #fff0f0;
        border: 1px solid #f0d0d0;
        border-radius: 6px;
        font-size: .7rem;
        font-weight: 800;
    }

    .core-checkout .cc-notice {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        margin-top: 17px;
        padding: 14px;
        color: #586574;
        background: #f4f6f8;
        border: 1px solid #e5e9ee;
        border-radius: 10px;
        font-size: .8rem;
        line-height: 1.65;
    }

    .core-checkout .cc-notice svg {
        flex-shrink: 0;
        margin-top: 1px;
    }

    .core-checkout .cc-summary {
        position: sticky;
        top: 22px;
    }

    .core-checkout .cc-summary .cc-card-body {
        padding: 23px;
    }

    .core-checkout .cc-summary-heading {
        display: flex;
        align-items: center;
        gap: 11px;
        margin-bottom: 22px;
    }

    .core-checkout .cc-summary-heading h2 {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 850;
    }

    .core-checkout .cc-summary-heading p {
        margin: 4px 0 0;
        color: var(--cc-muted);
        font-size: .78rem;
    }

    .core-checkout .cc-summary-product {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px solid #edf0f3;
    }

    .core-checkout .cc-summary-product:first-child {
        padding-top: 0;
    }

    .core-checkout .cc-product-name {
        color: #343a43;
        font-size: .87rem;
        font-weight: 750;
        line-height: 1.55;
        overflow-wrap: anywhere;
    }

    .core-checkout .cc-product-quantity {
        margin-top: 5px;
        color: var(--cc-muted);
        font-size: .78rem;
    }

    .core-checkout .cc-product-price {
        flex-shrink: 0;
        color: #343a43;
        font-size: .86rem;
        font-weight: 750;
        text-align: right;
        overflow-wrap: anywhere;
    }

    .core-checkout .cc-total {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-top: 20px;
        padding-top: 19px;
        border-top: 1px solid var(--cc-border);
    }

    .core-checkout .cc-total-label {
        font-size: .9rem;
        font-weight: 750;
    }

    .core-checkout .cc-total-value {
        color: var(--cc-dark);
        font-size: 1.23rem;
        font-weight: 850;
        text-align: right;
        overflow-wrap: anywhere;
    }

    .core-checkout .cc-submit {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        min-height: 51px;
        margin-top: 22px;
        padding: 13px 16px;
        color: #fff;
        background: var(--cc-dark);
        border: 1px solid var(--cc-dark);
        border-radius: 10px;
        font-size: .93rem;
        font-weight: 800;
        transition: background .2s, transform .2s;
    }

    .core-checkout .cc-submit:hover {
        color: #fff;
        background: #3b424d;
        transform: translateY(-1px);
    }

    .core-checkout .cc-back {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        min-height: 45px;
        margin-top: 10px;
        padding: 10px 14px;
        color: #5f6976;
        background: #fff;
        border: 1px solid #cbd2dc;
        border-radius: 9px;
        font-size: .87rem;
        font-weight: 650;
        text-decoration: none;
        transition: background .18s, border-color .18s;
    }

    .core-checkout .cc-back:hover {
        color: var(--cc-dark);
        background: #f6f7f9;
        border-color: #8e98a5;
    }

    .core-checkout .cc-summary-footnote {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        margin-top: 17px;
        padding-top: 15px;
        color: var(--cc-muted);
        border-top: 1px solid #edf0f3;
        font-size: .76rem;
        line-height: 1.6;
    }

    .core-checkout .cc-error {
        margin-bottom: 22px;
        padding: 16px 19px;
        color: #842029;
        background: #fff1f2;
        border: 1px solid #f1c8cd;
        border-radius: 11px;
    }

    .core-checkout .cc-error ul {
        margin: 0;
        padding-left: 19px;
    }

    .core-checkout .cc-error li + li {
        margin-top: 4px;
    }

    @media (min-width: 992px) {
        .core-checkout .cc-form-column {
            width: 62%;
        }

        .core-checkout .cc-summary-column {
            width: 38%;
        }
    }

    @media (max-width: 991.98px) {
        .core-checkout {
            padding-top: 30px;
        }

        .core-checkout .cc-summary {
            position: static;
        }
    }

    @media (max-width: 575.98px) {
        .core-checkout {
            padding-top: 25px;
            padding-bottom: 45px;
        }

        .core-checkout .cc-card-header {
            padding: 18px 17px 0;
        }

        .core-checkout .cc-card-body {
            padding: 19px 17px 20px;
        }

        .core-checkout .cc-summary .cc-card-body {
            padding: 19px;
        }

        .core-checkout .cc-section-icon {
            width: 38px;
            height: 38px;
        }

        .core-checkout .cc-provider-grid {
            gap: 7px;
        }

        .core-checkout .cc-provider-card {
            gap: 7px;
            min-height: 57px;
            padding: 8px;
        }

        .core-checkout .cc-payment-logo {
            width: 43px;
            height: 29px;
        }

        .core-checkout .cc-provider-name {
            font-size: .78rem;
        }

        .core-checkout .cc-payment-method {
            padding: 13px;
        }

        .core-checkout .cc-steps {
            gap: 7px;
            font-size: .72rem;
        }

        .core-checkout .cc-step {
            gap: 5px;
        }

        .core-checkout .cc-step-line {
            width: 17px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .core-checkout *,
        .core-checkout *::before,
        .core-checkout *::after {
            transition-duration: .01ms !important;
        }
    }
</style>

<div class="container core-checkout">

    {{-- HEADER --}}
    <header>
        <div class="cc-eyebrow">CORE / SECURE CHECKOUT</div>

        <h1 class="cc-title">Checkout</h1>

        <p class="cc-subtitle">
            Lengkapi data pembelianmu untuk melanjutkan pesanan.
        </p>

        <div class="cc-steps" aria-label="Tahapan belanja">
            <div class="cc-step">
                <span class="cc-step-number">1</span>
                <span>Keranjang</span>
            </div>

            <span class="cc-step-line"></span>

            <div class="cc-step active">
                <span class="cc-step-number">2</span>
                <span>Checkout</span>
            </div>

            <span class="cc-step-line"></span>

            <div class="cc-step">
                <span class="cc-step-number">3</span>
                <span>Pesanan</span>
            </div>
        </div>
    </header>

    {{-- VALIDASI --}}
    @if ($errors->any())
        <div class="cc-error" role="alert">
            <div class="fw-bold mb-2">
                Periksa kembali data checkout kamu.
            </div>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">

        {{-- FORM CHECKOUT --}}
        <div class="col-lg-7 cc-form-column">

            <form
                action="{{ route('checkout.store') }}"
                method="POST"
                id="checkout-form"
            >
                @csrf

                {{-- DATA PEMBELI --}}
                <section class="cc-card">

                    <div class="cc-card-header">
                        <div class="cc-section-icon" aria-hidden="true">
                            <svg width="21" height="21" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor"
                                 stroke-width="1.7" stroke-linecap="round"
                                 stroke-linejoin="round">
                                <circle cx="12" cy="8" r="4"/>
                                <path d="M5 21v-2a7 7 0 0 1 14 0v2"/>
                            </svg>
                        </div>

                        <div>
                            <h2 class="cc-section-title">Data Pembeli</h2>
                            <p class="cc-section-description">
                                Masukkan informasi untuk menghubungi kamu.
                            </p>
                        </div>
                    </div>

                    <div class="cc-card-body">

                        <div class="cc-field">
                            <label for="customer_name" class="cc-label">
                                Nama lengkap
                            </label>

                            <input
                                type="text"
                                id="customer_name"
                                name="customer_name"
                                class="cc-control"
                                value="{{ old('customer_name') }}"
                                placeholder="Masukkan nama lengkap"
                                maxlength="255"
                                autocomplete="name"
                                required
                            >
                        </div>

                        <div class="cc-field">
                            <label for="whatsapp" class="cc-label">
                                Nomor WhatsApp
                            </label>

                            <input
                                type="tel"
                                id="whatsapp"
                                name="whatsapp"
                                class="cc-control"
                                value="{{ old('whatsapp') }}"
                                placeholder="Contoh: 081234567890"
                                maxlength="20"
                                autocomplete="tel"
                                required
                            >

                            <small class="cc-help">
                                Gunakan nomor aktif agar toko dapat menghubungi kamu.
                            </small>
                        </div>

                    </div>
                </section>

                {{-- PENERIMAAN PESANAN --}}
                <section class="cc-card">

                    <div class="cc-card-header">
                        <div class="cc-section-icon" aria-hidden="true">
                            <svg width="21" height="21" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor"
                                 stroke-width="1.7" stroke-linecap="round"
                                 stroke-linejoin="round">
                                <path d="M3 7h18l-2 13H5L3 7Z"/>
                                <path d="M8 7a4 4 0 0 1 8 0"/>
                                <path d="M9 12v3M15 12v3"/>
                            </svg>
                        </div>

                        <div>
                            <h2 class="cc-section-title">Penerimaan Pesanan</h2>
                            <p class="cc-section-description">
                                Tentukan cara menerima produk yang dibeli.
                            </p>
                        </div>
                    </div>

                    <div class="cc-card-body">

                        <div class="cc-delivery-options mb-3">

                            <label for="delivery" class="cc-choice">
                                <input
                                    class="cc-radio"
                                    type="radio"
                                    name="fulfillment_method"
                                    id="delivery"
                                    value="delivery"
                                    {{ old('fulfillment_method', 'delivery') === 'delivery' ? 'checked' : '' }}
                                    required
                                >

                                <span>
                                    <span class="cc-choice-title">
                                        Pengiriman ke alamat
                                    </span>
                                    <span class="cc-choice-description">
                                        Produk dikirim ke alamat tujuanmu.
                                    </span>
                                </span>
                            </label>

                            <label for="pickup" class="cc-choice">
                                <input
                                    class="cc-radio"
                                    type="radio"
                                    name="fulfillment_method"
                                    id="pickup"
                                    value="pickup"
                                    {{ old('fulfillment_method') === 'pickup' ? 'checked' : '' }}
                                >

                                <span>
                                    <span class="cc-choice-title">
                                        Ambil langsung di toko
                                    </span>
                                    <span class="cc-choice-description">
                                        Datang dan ambil pesanan di toko CORE.
                                    </span>
                                </span>
                            </label>

                        </div>

                        <div id="address-field" class="cc-field">
                            <label for="address" class="cc-label">
                                Alamat pengiriman
                            </label>

                            <textarea
                                name="address"
                                id="address"
                                class="cc-control"
                                rows="3"
                                maxlength="2000"
                                placeholder="Nama jalan, nomor rumah, kecamatan, kota, dan kode pos"
                            >{{ old('address') }}</textarea>

                            <small class="cc-help">
                                Alamat wajib diisi jika memilih pengiriman.
                            </small>
                        </div>

                    </div>
                </section>

                {{-- METODE PEMBAYARAN --}}
                <section class="cc-card">

                    <div class="cc-card-header">
                        <div class="cc-section-icon" aria-hidden="true">
                            <svg width="21" height="21" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor"
                                 stroke-width="1.7" stroke-linecap="round"
                                 stroke-linejoin="round">
                                <rect x="2" y="5" width="20" height="14" rx="3"/>
                                <path d="M2 10h20M6 15h4"/>
                            </svg>
                        </div>

                        <div>
                            <h2 class="cc-section-title">Metode Pembayaran</h2>
                            <p class="cc-section-description">
                                Pilih metode pembayaran yang kamu inginkan.
                            </p>
                        </div>
                    </div>

                    <div class="cc-card-body">

                        @php
                            $banks = [
                                'bni' => 'BNI',
                                'bri' => 'BRI',
                                'mandiri' => 'Mandiri',
                                'bca' => 'BCA',
                            ];

                            $ewallets = [
                                'dana' => 'DANA',
                                'gopay' => 'GoPay',
                                'ovo' => 'OVO',
                                'shopeepay' => 'ShopeePay',
                            ];

                            $selectedPayment = old('payment_method', 'bank_transfer');
                        @endphp

                        {{-- BANK TRANSFER --}}
                        <div
                            class="cc-payment-method mb-3"
                            data-payment-card="bank_transfer"
                        >
                            <div class="cc-payment-heading">
                                <input
                                    class="cc-radio payment-method"
                                    type="radio"
                                    name="payment_method"
                                    id="bank_transfer"
                                    value="bank_transfer"
                                    {{ $selectedPayment === 'bank_transfer' ? 'checked' : '' }}
                                    required
                                >

                                <label for="bank_transfer">
                                    <span class="cc-choice-title">
                                        Transfer Bank / Virtual Account
                                    </span>
                                    <span class="cc-choice-description">
                                        Pilih bank untuk simulasi pembayaran.
                                    </span>
                                </label>
                            </div>

                            <div class="cc-provider-section" id="bank-options">
                                <p class="cc-provider-label">
                                    Pilih bank yang ingin digunakan:
                                </p>

                                <div class="cc-provider-grid">
                                    @foreach ($banks as $value => $label)
                                        <label class="cc-provider-card">
                                            <input
                                                type="radio"
                                                name="payment_provider"
                                                value="{{ $value }}"
                                                class="cc-provider-input provider-input"
                                                data-method="bank_transfer"
                                                {{ old('payment_provider') === $value ? 'checked' : '' }}
                                            >

                                            <img
                                                src="{{ asset('images/payments/' . $value . '.png') }}"
                                                alt="Logo {{ $label }}"
                                                class="cc-payment-logo"
                                                onerror="this.style.display='none';"
                                            >

                                            <span class="cc-provider-name">
                                                {{ $label }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- QRIS --}}
                        <div
                            class="cc-payment-method mb-3"
                            data-payment-card="qris"
                        >
                            <div class="cc-payment-heading">
                                <input
                                    class="cc-radio payment-method"
                                    type="radio"
                                    name="payment_method"
                                    id="qris"
                                    value="qris"
                                    {{ $selectedPayment === 'qris' ? 'checked' : '' }}
                                >

                                <label for="qris">
                                    <span class="cc-choice-title">QRIS</span>
                                    <span class="cc-choice-description">
                                        Simulasi pembayaran menggunakan kode QR.
                                    </span>
                                </label>

                                <span class="badge text-bg-secondary">
                                    Simulasi
                                </span>
                            </div>

                            <div class="cc-provider-section" id="qris-options">

                                <label class="cc-provider-card">
                                    <input
                                        type="radio"
                                        name="payment_provider"
                                        value="qris"
                                        class="cc-provider-input provider-input"
                                        data-method="qris"
                                        {{ old('payment_provider') === 'qris' ? 'checked' : '' }}
                                    >

                                    <img
                                        src="{{ asset('images/payments/qris-dummy.png') }}"
                                        alt="Ilustrasi QRIS"
                                        class="cc-payment-logo"
                                        onerror="this.style.display='none';"
                                    >

                                    <span class="cc-provider-name">
                                        QRIS Indonesia
                                    </span>
                                </label>

                                <div class="cc-qris-box">
                                    <img
                                        src="{{ asset('images/payments/qris-dummy.png') }}"
                                        alt="Ilustrasi QRIS dummy CORE"
                                        class="cc-qris-image"
                                        onerror="
                                            this.style.display='none';
                                            document.getElementById('qris-fallback').style.display='block';
                                        "
                                    >

                                    <div id="qris-fallback" class="cc-qris-fallback">
                                        <div class="cc-fake-qr" aria-hidden="true">
                                            <span></span><span></span><span></span>
                                            <span></span><span></span><span></span>
                                            <span></span><span></span><span></span>
                                            <span></span><span></span><span></span>
                                            <span></span><span></span><span></span>
                                            <span></span><span></span><span></span>
                                            <span></span><span></span><span></span>
                                            <span></span><span></span><span></span>
                                            <span></span><span></span><span></span>
                                        </div>
                                    </div>

                                    <div class="fw-bold mt-3">QRIS — CORE</div>

                                    <span class="cc-qris-warning">
                                        DUMMY — BUKAN UNTUK PEMBAYARAN
                                    </span>

                                    <p class="small text-secondary mt-3 mb-0">
                                        Gambar ini hanya ilustrasi dan bukan kode QR pembayaran aktif.
                                    </p>
                                </div>

                            </div>
                        </div>

                        {{-- E-WALLET --}}
                        <div
                            class="cc-payment-method"
                            data-payment-card="ewallet"
                        >
                            <div class="cc-payment-heading">
                                <input
                                    class="cc-radio payment-method"
                                    type="radio"
                                    name="payment_method"
                                    id="ewallet"
                                    value="ewallet"
                                    {{ $selectedPayment === 'ewallet' ? 'checked' : '' }}
                                >

                                <label for="ewallet">
                                    <span class="cc-choice-title">E-Wallet</span>
                                    <span class="cc-choice-description">
                                        DANA, GoPay, OVO, atau ShopeePay.
                                    </span>
                                </label>
                            </div>

                            <div class="cc-provider-section" id="ewallet-options">
                                <p class="cc-provider-label">
                                    Pilih e-wallet yang ingin digunakan:
                                </p>

                                <div class="cc-provider-grid">
                                    @foreach ($ewallets as $value => $label)
                                        <label class="cc-provider-card">
                                            <input
                                                type="radio"
                                                name="payment_provider"
                                                value="{{ $value }}"
                                                class="cc-provider-input provider-input"
                                                data-method="ewallet"
                                                {{ old('payment_provider') === $value ? 'checked' : '' }}
                                            >

                                            <img
                                                src="{{ asset('images/payments/' . $value . '.png') }}"
                                                alt="Logo {{ $label }}"
                                                class="cc-payment-logo"
                                                onerror="this.style.display='none';"
                                            >

                                            <span class="cc-provider-name">
                                                {{ $label }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        @error('payment_provider')
                            <div class="text-danger small mt-2">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="cc-notice">
                            <svg width="20" height="20" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor"
                                 stroke-width="1.7" stroke-linecap="round"
                                 stroke-linejoin="round" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 11v5M12 7h.01"/>
                            </svg>

                            <span>
                                <strong>Informasi pembayaran.</strong>
                                Pembayaran pada versi ini masih berupa simulasi.
                                Tidak ada transaksi uang sungguhan yang diproses.
                            </span>
                        </div>

                    </div>
                </section>

                <button type="submit" class="cc-submit">
                    <svg width="19" height="19" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round"
                         stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14M13 6l6 6-6 6"/>
                    </svg>

                    Buat Pesanan
                </button>

            </form>
        </div>

        {{-- RINGKASAN PESANAN --}}
        <aside class="col-lg-5 cc-summary-column">
            <div class="cc-card cc-summary">

                <div class="cc-card-body">

                    <div class="cc-summary-heading">
                        <div class="cc-section-icon" aria-hidden="true">
                            <svg width="21" height="21" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor"
                                 stroke-width="1.7" stroke-linecap="round"
                                 stroke-linejoin="round">
                                <path d="M6 2h12v20l-6-4-6 4V2Z"/>
                                <path d="M9 7h6M9 11h6"/>
                            </svg>
                        </div>

                        <div>
                            <h2>Ringkasan Pesanan</h2>
                            <p>Periksa kembali produk pilihanmu.</p>
                        </div>
                    </div>

                    <div class="cc-summary-products">
                        @foreach ($cart as $productId => $quantity)
                            @if (isset($products[$productId]))
                                @php
                                    $product = $products[$productId];
                                    $price = $product->discounted_price;
                                @endphp

                                <div class="cc-summary-product">
                                    <div>
                                        <div class="cc-product-name">
                                            {{ $product->name }}
                                        </div>

                                        <div class="cc-product-quantity">
                                            {{ $quantity }} ×
                                            Rp {{ number_format($price, 0, ',', '.') }}
                                        </div>
                                    </div>

                                    <div class="cc-product-price">
                                        Rp {{ number_format($price * $quantity, 0, ',', '.') }}
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="cc-total">
                        <span class="cc-total-label">Total belanja</span>

                        <strong class="cc-total-value">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </strong>
                    </div>

                    <button
                        type="submit"
                        form="checkout-form"
                        class="cc-submit"
                        style="margin-top: 22px;"
                    >
                        Buat Pesanan

                        <svg width="18" height="18" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor"
                             stroke-width="1.8" stroke-linecap="round"
                             stroke-linejoin="round" aria-hidden="true">
                            <path d="M5 12h14M13 6l6 6-6 6"/>
                        </svg>
                    </button>

                    <a href="{{ route('cart.index') }}" class="cc-back">
                        <svg width="17" height="17" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor"
                             stroke-width="1.8" stroke-linecap="round"
                             stroke-linejoin="round" aria-hidden="true">
                            <path d="M19 12H5M12 19l-7-7 7-7"/>
                        </svg>

                        Kembali ke Keranjang
                    </a>

                    <div class="cc-summary-footnote">
                        <svg width="18" height="18" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor"
                             stroke-width="1.7" stroke-linecap="round"
                             stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11Z"/>
                            <path d="m9 12 2 2 4-4"/>
                        </svg>

                        <span>
                            Pastikan data pembeli, pengiriman, dan pembayaran
                            sudah benar sebelum membuat pesanan.
                        </span>
                    </div>

                </div>
            </div>
        </aside>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const delivery = document.getElementById('delivery');
    const pickup = document.getElementById('pickup');
    const addressField = document.getElementById('address-field');
    const address = document.getElementById('address');

    const paymentMethods = document.querySelectorAll('.payment-method');
    const providerInputs = document.querySelectorAll('.provider-input');

    const providerSections = {
        bank_transfer: document.getElementById('bank-options'),
        qris: document.getElementById('qris-options'),
        ewallet: document.getElementById('ewallet-options')
    };

    const paymentCards = document.querySelectorAll('[data-payment-card]');

    function toggleAddress() {
        const isDelivery = delivery.checked;

        addressField.style.display = isDelivery ? 'block' : 'none';
        address.required = isDelivery;
    }

    function togglePaymentProviders() {
        const selectedMethod = document.querySelector(
            'input[name="payment_method"]:checked'
        );

        const method = selectedMethod ? selectedMethod.value : null;

        Object.entries(providerSections).forEach(function ([key, section]) {
            if (!section) {
                return;
            }

            section.style.display = key === method ? 'block' : 'none';
        });

        paymentCards.forEach(function (card) {
            card.classList.toggle(
                'selected',
                card.dataset.paymentCard === method
            );
        });

        providerInputs.forEach(function (input) {
            const isActive = input.dataset.method === method;

            input.disabled = !isActive;
            input.required = isActive;
        });

        // QRIS menggunakan satu provider khusus.
        if (method === 'qris') {
            const qrisInput = document.querySelector(
                '.provider-input[data-method="qris"]'
            );

            if (qrisInput) {
                qrisInput.checked = true;
            }
        }

        // Bersihkan provider jika tidak sesuai metode pembayaran.
        const selectedProvider = document.querySelector(
            '.provider-input:checked'
        );

        if (
            selectedProvider &&
            selectedProvider.dataset.method !== method
        ) {
            selectedProvider.checked = false;
        }
    }

    delivery.addEventListener('change', toggleAddress);
    pickup.addEventListener('change', toggleAddress);

    paymentMethods.forEach(function (input) {
        input.addEventListener('change', togglePaymentProviders);
    });

    // Inisialisasi berdasarkan pilihan lama jika validasi gagal.
    toggleAddress();
    togglePaymentProviders();
});
</script>
@endsection