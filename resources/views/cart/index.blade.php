@extends('layouts.app')

@section('title', 'CORE - Computer Hardware Store')

@section('content')
<div class="container py-5">

    <h1 class="fw-bold mb-2">Keranjang Belanja</h1>
    <p class="text-secondary mb-4">
        Periksa produk pilihanmu sebelum melanjutkan.
    </p>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (empty($cart))
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

            {{-- Daftar produk --}}
            <div class="col-lg-8" id="cart-items">

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

                        <div
                            class="card border-0 shadow-sm mb-3"
                            data-cart-item
                            data-price="{{ $price }}"
                            data-stock="{{ $product->stock }}"
                        >
                            <div class="card-body">
                                <div class="row align-items-center g-3">

                                    {{-- Gambar produk --}}
                                    <div class="col-4 col-md-3">
                                        <img
                                            src="{{ $product->image_url ?: 'https://placehold.co/300x200?text=CORE' }}"
                                            alt="{{ $product->name }}"
                                            class="img-fluid rounded"
                                            style="width:100%;height:140px;object-fit:contain;"
                                        >
                                    </div>

                                    {{-- Informasi produk --}}
                                    <div class="col-8 col-md-9">

                                        <h5 class="fw-bold mb-2">
                                            {{ $product->name }}
                                        </h5>

                                        @if (
                                            $product->discount_active &&
                                            $product->discount_percentage > 0
                                        )
                                            <p class="text-secondary text-decoration-line-through small mb-1">
                                                Rp {{ number_format((float) $product->price, 0, ',', '.') }}
                                            </p>

                                            <p class="text-danger fw-bold mb-2">
                                                Rp {{ number_format($price, 0, ',', '.') }}
                                            </p>
                                        @else
                                            <p class="fw-semibold mb-2">
                                                Rp {{ number_format($price, 0, ',', '.') }}
                                            </p>
                                        @endif

                                        <p class="text-secondary small mb-2">
                                            Stok tersedia: {{ $product->stock }}
                                        </p>

                                        {{-- Ubah jumlah otomatis --}}
                                        <form
                                            action="{{ route('cart.update', $product->id) }}"
                                            method="POST"
                                            data-quantity-form
                                            class="d-flex align-items-center flex-wrap gap-2 mt-3"
                                        >
                                            @csrf

                                            <label
                                                for="quantity-{{ $product->id }}"
                                                class="small"
                                            >
                                                Jumlah:
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
                                                class="form-control form-control-sm text-center"
                                                style="width:85px;"
                                                required
                                                @disabled($product->stock < 1)
                                            >

                                            <span
                                                data-saving
                                                class="small text-secondary"
                                                aria-live="polite"
                                            ></span>
                                        </form>

                                        {{-- Hapus produk --}}
                                        <form
                                            action="{{ route('cart.remove', $product->id) }}"
                                            method="POST"
                                            class="mt-2"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-outline-danger btn-sm"
                                            >
                                                Hapus produk
                                            </button>
                                        </form>

                                        {{-- Subtotal --}}
                                        <p class="fw-bold mt-3 mb-0">
                                            Subtotal:
                                            <span data-subtotal>
                                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                                            </span>
                                        </p>

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
                        </div>

                    @endif
                @endforeach

                <a href="{{ route('home') }}" class="btn btn-outline-dark mt-2">
                    &larr; Lanjut Belanja
                </a>

            </div>

            {{-- Ringkasan belanja --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <h5 class="fw-bold">Ringkasan Belanja</h5>

                        <div class="d-flex justify-content-between mt-3">
                            <span>Jumlah barang</span>
                            <strong>
                                <span id="cart-count">0</span> item
                            </strong>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <span>Total</span>
                            <strong id="cart-total">Rp 0</strong>
                        </div>

                        <a
                            href="{{ route('checkout.index') }}"
                            class="btn btn-dark btn-lg w-100 mt-3"
                            id="checkout-button"
                        >
                            Lanjut ke Checkout
                        </a>

                        <p
                            id="cart-message"
                            class="small text-secondary mt-2 mb-0"
                            aria-live="polite"
                        ></p>

                    </div>
                </div>
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

    // Menghitung subtotal dan total secara langsung.
    function updateTotals() {
        let total = 0;
        let count = 0;
        let invalid = false;

        document.querySelectorAll('[data-cart-item]').forEach(function (item) {
            const input = item.querySelector('[data-quantity]');
            const subtotalElement = item.querySelector('[data-subtotal]');

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
            checkoutButton.classList.toggle(
                'disabled',
                count === 0 || invalid
            );

            checkoutButton.setAttribute(
                'aria-disabled',
                count === 0 || invalid ? 'true' : 'false'
            );
        }
    }

    // Simpan perubahan jumlah ke session Laravel.
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

        // FormData harus dibuat SEBELUM input dinonaktifkan.
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

        // Harga langsung berubah saat angka diketik.
        input.addEventListener('input', function () {
            statusMessage(form, '');
            updateTotals();
        });

        // Simpan otomatis saat pengguna selesai mengubah angka.
        input.addEventListener('change', function () {
            saveQuantity(form, input);
        });

        // Enter juga dapat digunakan untuk menyimpan jumlah.
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

    // Cegah klik checkout saat masih ada perubahan yang belum tersimpan.
    if (checkoutButton) {
        checkoutButton.addEventListener('click', function (event) {
            const unsaved = Array.from(
                document.querySelectorAll('[data-quantity]')
            ).some(function (input) {
                return input.value !== input.dataset.savedValue;
            });

            if (unsaved) {
                event.preventDefault();
                messageElement.textContent =
                    'Tunggu sampai perubahan jumlah tersimpan.';
            }
        });
    }

    updateTotals();
});
</script>
@endsection