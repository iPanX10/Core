<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hasil Pencarian Pesanan | CORE</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            background: #f4f6f9;
            color: #212529;
            font-family: Arial, sans-serif;
        }

        .result-card {
            max-width: 760px;
            margin: 40px auto;
            padding: 32px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
        }

        .brand {
            font-size: 30px;
            font-weight: 800;
            letter-spacing: 3px;
        }

        .muted {
            color: #6c757d;
        }

        .order-number {
            padding: 18px;
            background: #f8f9fa;
            border-radius: 10px;
            overflow-wrap: anywhere;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-value {
            text-align: right;
            overflow-wrap: anywhere;
        }

        .total-box {
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .total-price {
            font-size: 24px;
            font-weight: 800;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            background: #e9f7ef;
            color: #198754;
            font-size: 12px;
            font-weight: 700;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #842029;
        }

        .btn-whatsapp {
            background: #198754;
            color: #fff;
            border: 1px solid #198754;
        }

        .btn-whatsapp:hover {
            background: #157347;
            border-color: #146c43;
            color: #fff;
        }

        @media (max-width: 576px) {
            .result-card {
                margin: 16px 10px;
                padding: 22px;
            }

            .info-row {
                flex-direction: column;
                gap: 5px;
            }

            .info-value {
                text-align: left;
            }

            .total-price {
                font-size: 21px;
            }
        }
    </style>
</head>

<body>
    @php
        $statusLabels = [
            'pending' => 'Menunggu',
            'processing' => 'Diproses',
            'shipped' => 'Dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        $paymentLabels = [
            'unpaid' => 'Belum Dibayar',
            'paid' => 'Sudah Dibayar',
        ];

        $paymentMethodLabels = [
            'bank_transfer' => 'Transfer Bank',
            'qris' => 'QRIS',
            'ewallet' => 'E-Wallet',
        ];

        $status = $statusLabels[$order->status] ?? $order->status;

        $paymentStatus = $paymentLabels[$order->payment_status]
            ?? $order->payment_status;

        $isCancelled = $order->status === 'cancelled';

        $fulfillmentLabels = [
            'pickup' => 'Ambil di Tempat',
            'delivery' => 'Dikirim',
        ];

        // Pesan otomatis untuk WhatsApp toko CORE
        $whatsappMessage = "Halo CORE, saya ingin menanyakan pesanan saya.\n\n"
            . "Nomor Pesanan: {$order->order_number}\n"
            . "Nama: {$order->customer_name}\n"
            . "Status Pesanan: {$status}\n"
            . "Status Pembayaran: {$paymentStatus}\n\n"
            . "Mohon informasi lebih lanjut. Terima kasih.";

        $whatsappUrl = 'https://wa.me/6285123300335?text='
            . urlencode($whatsappMessage);
    @endphp

    <main class="result-card">

        {{-- Header --}}
        <header class="text-center mb-4">
            <div class="brand">CORE</div>

            <div class="muted small">
                Computer Hardware Store
            </div>

            <h4 class="fw-bold mt-4">
                Hasil Pencarian Pesanan
            </h4>

            <p class="muted mb-0">
                Pesanan ditemukan. Berikut ringkasan pesanan Anda.
            </p>
        </header>

        {{-- Nomor Pesanan --}}
        <section class="order-number text-center mb-4">
            <div class="muted small">Nomor Pesanan</div>

            <div class="fw-bold fs-5">
                {{ $order->order_number }}
            </div>
        </section>

        {{-- Status Pesanan dan Pembayaran --}}
        <section class="mb-4">
            <h5 class="fw-bold mb-3">Status Pesanan</h5>

            <div class="d-flex flex-wrap gap-2">
                <span class="status {{ $isCancelled ? 'status-cancelled' : '' }}">
                    {{ $status }}
                </span>

                <span class="badge {{ $order->payment_status === 'paid' ? 'text-bg-success' : 'text-bg-warning' }} d-flex align-items-center">
                    {{ $paymentStatus }}
                </span>
            </div>
        </section>

        {{-- Informasi Pelanggan --}}
        <section class="mb-4">
            <h5 class="fw-bold mb-2">Informasi Pelanggan</h5>

            <div class="info-row">
                <span class="muted">Nama Pembeli</span>

                <strong class="info-value">
                    {{ $order->customer_name }}
                </strong>
            </div>

            <div class="info-row">
                <span class="muted">WhatsApp</span>

                <strong class="info-value">
                    {{ $order->whatsapp }}
                </strong>
            </div>

            {{-- Informasi Pengambilan/Pengiriman --}}
            @if ($order->fulfillment_method === 'pickup')
                <div class="info-row">
                    <span class="muted">Metode Pengambilan</span>

                    <strong class="info-value">
                        {{ $fulfillmentLabels['pickup'] }}
                    </strong>
                </div>

            @elseif ($order->fulfillment_method === 'delivery')
                <div class="info-row">
                    <span class="muted">Metode Pengiriman</span>

                    <strong class="info-value">
                        {{ $fulfillmentLabels['delivery'] }}
                    </strong>
                </div>

                <div class="info-row">
                    <span class="muted">Alamat Pengiriman</span>

                    <strong class="info-value">
                        {{ $order->address ?: '-' }}
                    </strong>
                </div>
            @endif

            <div class="info-row">
                <span class="muted">Metode Pembayaran</span>

                <strong class="info-value">
                    {{ $paymentMethodLabels[$order->payment_method] ?? $order->payment_method }}
                </strong>
            </div>

            <div class="info-row">
                <span class="muted">Tanggal Pesanan</span>

                <strong class="info-value">
                    {{ $order->created_at ? $order->created_at->format('d M Y, H:i') . ' WIB' : '-' }}
                </strong>
            </div>
        </section>

        {{-- Ringkasan Produk --}}
        <section class="mb-4">
            <h5 class="fw-bold mb-3">Ringkasan Produk</h5>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($order->items as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>

                                <td class="text-center">
                                    {{ $item->quantity }}
                                </td>

                                <td class="text-end">
                                    Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center muted">
                                    Tidak ada rincian produk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Total Pembayaran --}}
        <section class="total-box mb-4">
            <div class="muted mb-2">Total Pembayaran</div>

            <div class="total-price">
                Rp {{ number_format((float) $order->total, 0, ',', '.') }}
            </div>
        </section>

        {{-- Tombol Aksi --}}
        <section class="d-flex flex-wrap gap-2">

            {{-- Lacak Pesanan --}}
            <a
                href="{{ route('checkout.success', [
                    'orderNumber' => $order->order_number,
                    'accessToken' => $order->access_token,
                ]) }}"
                class="btn btn-dark flex-fill"
            >
                Lacak Pesanan
            </a>

            {{-- Lihat Invoice --}}
            <a
                href="{{ route('checkout.invoice', [
                    'orderNumber' => $order->order_number,
                    'accessToken' => $order->access_token,
                ]) }}"
                class="btn btn-outline-dark flex-fill"
            >
                Lihat Invoice
            </a>

            {{-- Hubungi WhatsApp CORE --}}
            <a
                href="{{ $whatsappUrl }}"
                target="_blank"
                rel="noopener noreferrer"
                class="btn btn-whatsapp flex-fill"
            >
                Hubungi CORE via WhatsApp
            </a>

        </section>

        {{-- Navigasi --}}
        <div class="text-center mt-4">
            <a
                href="{{ route('orders.history') }}"
                class="text-decoration-none text-secondary"
            >
                Cari Pesanan Lain
            </a>

            <span class="text-secondary mx-2">|</span>

            <a
                href="{{ route('home') }}"
                class="text-decoration-none text-secondary"
            >
                Kembali ke Beranda
            </a>
        </div>

    </main>
</body>
</html>