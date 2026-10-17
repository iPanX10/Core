@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">Checkout</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        {{-- FORM CHECKOUT --}}
        <div class="col-lg-7">
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf

                {{-- DATA PEMBELI --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Data Pembeli</h5>

                        <div class="mb-3">
                            <label for="customer_name" class="form-label">
                                Nama lengkap
                            </label>
                            <input
                                type="text"
                                id="customer_name"
                                name="customer_name"
                                class="form-control"
                                value="{{ old('customer_name') }}"
                                maxlength="255"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="whatsapp" class="form-label">
                                Nomor WhatsApp
                            </label>
                            <input
                                type="tel"
                                id="whatsapp"
                                name="whatsapp"
                                class="form-control"
                                value="{{ old('whatsapp') }}"
                                placeholder="Contoh: 081234567890"
                                maxlength="20"
                                required
                            >
                        </div>
                    </div>
                </div>

                {{-- PENERIMAAN PESANAN --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Penerimaan Pesanan</h5>

                        <div class="form-check mb-2">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="fulfillment_method"
                                id="delivery"
                                value="delivery"
                                {{ old('fulfillment_method', 'delivery') === 'delivery' ? 'checked' : '' }}
                                required
                            >
                            <label class="form-check-label" for="delivery">
                                Pengiriman ke alamat
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="fulfillment_method"
                                id="pickup"
                                value="pickup"
                                {{ old('fulfillment_method') === 'pickup' ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="pickup">
                                Ambil langsung di toko (pickup)
                            </label>
                        </div>

                        <div class="mb-3" id="address-field">
                            <label for="address" class="form-label">
                                Alamat pengiriman
                            </label>
                            <textarea
                                name="address"
                                id="address"
                                class="form-control"
                                rows="3"
                                maxlength="2000"
                                placeholder="Masukkan alamat lengkap"
                            >{{ old('address') }}</textarea>

                            <small class="text-secondary">
                                Alamat hanya wajib jika memilih pengiriman.
                            </small>
                        </div>
                    </div>
                </div>

                {{-- METODE PEMBAYARAN --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Metode Pembayaran</h5>

                        {{-- TRANSFER BANK / VA --}}
                        <div class="payment-method-card mb-3">
                            <div class="form-check">
                                <input
                                    class="form-check-input payment-method"
                                    type="radio"
                                    name="payment_method"
                                    id="bank_transfer"
                                    value="bank_transfer"
                                    {{ old('payment_method', 'bank_transfer') === 'bank_transfer' ? 'checked' : '' }}
                                    required
                                >
                                <label
                                    class="form-check-label fw-semibold"
                                    for="bank_transfer"
                                >
                                    Transfer Bank / Virtual Account
                                </label>
                            </div>

                            <div class="provider-options mt-3 ps-4" id="bank-options">
                                <p class="small text-secondary mb-2">
                                    Pilih bank yang ingin digunakan:
                                </p>

                                @php
                                    $banks = [
                                        'bni' => 'BNI',
                                        'bri' => 'BRI',
                                        'mandiri' => 'Mandiri',
                                        'bca' => 'BCA',
                                    ];
                                @endphp

                                <div class="row g-2">
                                    @foreach ($banks as $value => $label)
                                        <div class="col-6">
                                            <label class="provider-card w-100">
                                                <input
                                                    type="radio"
                                                    name="payment_provider"
                                                    value="{{ $value }}"
                                                    class="form-check-input provider-input"
                                                    data-method="bank_transfer"
                                                    {{ old('payment_provider') === $value ? 'checked' : '' }}
                                                >

                                                <img
                                                    src="{{ asset('images/payments/' . $value . '.png') }}"
                                                    alt="Logo {{ $label }}"
                                                    class="payment-logo"
                                                    onerror="this.style.display='none';"
                                                >

                                                <span class="fw-semibold">
                                                    {{ $label }}
                                                </span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- QRIS --}}
                        <div class="payment-method-card mb-3">
                            <div class="form-check">
                                <input
                                    class="form-check-input payment-method"
                                    type="radio"
                                    name="payment_method"
                                    id="qris"
                                    value="qris"
                                    {{ old('payment_method') === 'qris' ? 'checked' : '' }}
                                >
                                <label class="form-check-label fw-semibold" for="qris">
                                    QRIS
                                </label>
                                <span class="badge text-bg-secondary ms-2">
                                    Simulasi
                                </span>
                            </div>

                            <div class="provider-options mt-3 ps-4" id="qris-options">
                                <label class="provider-card w-100">
                                    <input
                                        type="radio"
                                        name="payment_provider"
                                        value="qris"
                                        class="form-check-input provider-input"
                                        data-method="qris"
                                        {{ old('payment_provider') === 'qris' ? 'checked' : '' }}
                                    >

                                    <img
                                        src="{{ asset('images/payments/qris-dummy.png') }}"
                                        alt="QRIS dummy"
                                        class="payment-logo"
                                        onerror="this.style.display='none';"
                                    >

                                    <span class="fw-semibold">QRIS Indonesia</span>
                                </label>

                                <div class="qris-placeholder mt-3 text-center">
                                    <img
                                        src="{{ asset('images/payments/qris-dummy.png') }}"
                                        alt="Ilustrasi QRIS dummy CORE"
                                        class="qris-dummy-image"
                                        onerror="this.style.display='none'; document.getElementById('qris-fallback').style.display='block';"
                                    >

                                    <div id="qris-fallback" style="display:none;">
                                        <div class="fake-qr" aria-hidden="true">
                                            <span></span><span></span><span></span>
                                            <span></span><span></span><span></span>
                                            <span></span><span></span><span></span>
                                        </div>
                                    </div>

                                    <div class="fw-semibold mt-2">QRIS — CORE</div>
                                    <span class="badge text-bg-danger mt-2">
                                        DUMMY — BUKAN UNTUK PEMBAYARAN
                                    </span>

                                    <div class="small text-secondary mt-2">
                                        Gambar ini hanya ilustrasi, bukan kode QR pembayaran aktif.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- E-WALLET --}}
                        <div class="payment-method-card mb-3">
                            <div class="form-check">
                                <input
                                    class="form-check-input payment-method"
                                    type="radio"
                                    name="payment_method"
                                    id="ewallet"
                                    value="ewallet"
                                    {{ old('payment_method') === 'ewallet' ? 'checked' : '' }}
                                >
                                <label class="form-check-label fw-semibold" for="ewallet">
                                    E-Wallet
                                </label>
                            </div>

                            <div class="provider-options mt-3 ps-4" id="ewallet-options">
                                <p class="small text-secondary mb-2">
                                    Pilih e-wallet yang ingin digunakan:
                                </p>

                                @php
                                    $ewallets = [
                                        'dana' => 'DANA',
                                        'gopay' => 'GoPay',
                                        'ovo' => 'OVO',
                                        'shopeepay' => 'ShopeePay',
                                    ];
                                @endphp

                                <div class="row g-2">
                                    @foreach ($ewallets as $value => $label)
                                        <div class="col-6">
                                            <label class="provider-card w-100">
                                                <input
                                                    type="radio"
                                                    name="payment_provider"
                                                    value="{{ $value }}"
                                                    class="form-check-input provider-input"
                                                    data-method="ewallet"
                                                    {{ old('payment_provider') === $value ? 'checked' : '' }}
                                                >

                                                <img
                                                    src="{{ asset('images/payments/' . $value . '.png') }}"
                                                    alt="Logo {{ $label }}"
                                                    class="payment-logo"
                                                    onerror="this.style.display='none';"
                                                >

                                                <span class="fw-semibold">
                                                    {{ $label }}
                                                </span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        @error('payment_provider')
                            <div class="text-danger small mt-2">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="alert alert-info mt-3 mb-0 small">
                            Pembayaran pada versi ini masih berupa simulasi.
                            Tidak ada transaksi uang sungguhan yang diproses.
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-dark btn-lg w-100">
                    Buat Pesanan
                </button>
            </form>
        </div>

        {{-- RINGKASAN PESANAN --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Ringkasan Pesanan</h5>

                    @foreach ($cart as $productId => $quantity)
                        @if (isset($products[$productId]))
                            @php
                                $product = $products[$productId];
                                $price = $product->discounted_price;
                            @endphp

                            <div class="d-flex justify-content-between gap-3 mb-3">
                                <div>
                                    <div class="fw-semibold">
                                        {{ $product->name }}
                                    </div>

                                    <small class="text-secondary">
                                        {{ $quantity }} ×
                                        Rp {{ number_format($price, 0, ',', '.') }}
                                    </small>
                                </div>

                                <div class="text-end fw-semibold">
                                    Rp {{ number_format($price * $quantity, 0, ',', '.') }}
                                </div>
                            </div>
                        @endif
                    @endforeach

                    <hr>

                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <a
                        href="{{ route('cart.index') }}"
                        class="btn btn-outline-secondary w-100 mt-3"
                    >
                        Kembali ke Keranjang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .payment-method-card {
        padding: 14px;
        border: 1px solid #dee2e6;
        border-radius: 10px;
    }

    .provider-options {
        display: none;
    }

    .provider-card {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px;
        min-height: 58px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        cursor: pointer;
        transition: border-color .2s, background-color .2s;
    }

    .provider-card:has(input:checked) {
        border-color: #212529;
        background: #f5f6f7;
    }

    .provider-card:hover {
        border-color: #6c757d;
    }

    .provider-card input {
        flex-shrink: 0;
        margin: 0;
    }

    .payment-logo {
        display: block;
        width: 75px;
        height: 35px;
        object-fit: contain;
        flex-shrink: 0;
        border-radius: 5px;
    }

    .qris-placeholder {
        padding: 20px;
        border: 1px dashed #ced4da;
        border-radius: 10px;
        background: #f8f9fa;
    }

    .qris-dummy-image {
        display: block;
        width: 240px;
        max-width: 100%;
        height: auto;
        margin: 0 auto;
        border-radius: 8px;
    }

    .fake-qr {
        display: grid;
        grid-template-columns: repeat(9, 10px);
        gap: 3px;
        justify-content: center;
        margin: 0 auto;
    }

    .fake-qr span {
        width: 10px;
        height: 10px;
        background: #212529;
    }

    .fake-qr span:nth-child(even) {
        background: #dee2e6;
    }

    @media (max-width: 576px) {
        .provider-card {
            padding: 9px;
            gap: 6px;
            font-size: 13px;
        }

        .payment-logo {
            width: 55px;
            height: 30px;
        }
    }
</style>

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

        Object.entries(providerSections).forEach(([key, section]) => {
            section.style.display = key === method ? 'block' : 'none';
        });

        providerInputs.forEach(input => {
            const isActive = input.dataset.method === method;
            input.disabled = !isActive;
            input.required = isActive;
        });

        // QRIS hanya memiliki satu pilihan provider.
        if (method === 'qris') {
            const qrisInput = document.querySelector(
                '.provider-input[data-method="qris"]'
            );

            if (qrisInput) {
                qrisInput.checked = true;
            }
        }

        // Hapus provider yang tidak sesuai metode terpilih.
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

    paymentMethods.forEach(input => {
        input.addEventListener('change', togglePaymentProviders);
    });

    toggleAddress();
    togglePaymentProviders();
});
</script>
@endsection