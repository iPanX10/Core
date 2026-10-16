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
        <div class="col-lg-7">
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Data Pembeli</h5>

                        <div class="mb-3">
                            <label class="form-label">Nama lengkap</label>
                            <input
                                type="text"
                                name="customer_name"
                                class="form-control"
                                value="{{ old('customer_name') }}"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor WhatsApp</label>
                            <input
                                type="tel"
                                name="whatsapp"
                                class="form-control"
                                value="{{ old('whatsapp') }}"
                                placeholder="Contoh: 081234567890"
                                required
                            >
                        </div>
                    </div>
                </div>

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
                            <label class="form-label">Alamat pengiriman</label>
                            <textarea
                                name="address"
                                id="address"
                                class="form-control"
                                rows="3"
                                placeholder="Masukkan alamat lengkap"
                            >{{ old('address') }}</textarea>
                            <small class="text-secondary">
                                Alamat hanya wajib jika memilih pengiriman.
                            </small>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Metode Pembayaran</h5>

                        <div class="form-check mb-2">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="payment_method"
                                id="bank_transfer"
                                value="bank_transfer"
                                {{ old('payment_method', 'bank_transfer') === 'bank_transfer' ? 'checked' : '' }}
                                required
                            >
                            <label class="form-check-label" for="bank_transfer">
                                Transfer bank / Virtual Account
                            </label>
                        </div>

                        <div class="form-check mb-2">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="payment_method"
                                id="qris"
                                value="qris"
                                {{ old('payment_method') === 'qris' ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="qris">
                                QRIS (simulasi)
                            </label>
                        </div>

                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="payment_method"
                                id="ewallet"
                                value="ewallet"
                                {{ old('payment_method') === 'ewallet' ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="ewallet">
                                E-wallet (simulasi)
                            </label>
                        </div>

                        <div class="alert alert-info mt-3 mb-0 small">
                            Pembayaran pada versi ini masih berupa simulasi.
                            Belum ada transaksi uang sungguhan.
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-dark btn-lg w-100">
                    Buat Pesanan
                </button>
            </form>
        </div>

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

                    <a href="{{ route('cart.index') }}"
                       class="btn btn-outline-secondary w-100 mt-3">
                        Kembali ke Keranjang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const delivery = document.getElementById('delivery');
    const pickup = document.getElementById('pickup');
    const addressField = document.getElementById('address-field');
    const address = document.getElementById('address');

    function toggleAddress() {
        const isDelivery = delivery.checked;

        addressField.style.display = isDelivery ? 'block' : 'none';
        address.required = isDelivery;
    }

    delivery.addEventListener('change', toggleAddress);
    pickup.addEventListener('change', toggleAddress);

    toggleAddress();
</script>
@endsection