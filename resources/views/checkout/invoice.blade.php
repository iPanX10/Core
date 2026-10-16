<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Invoice {{ $order->order_number }} | CORE</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background: #f4f6f9;
            color: #212529;
            font-family: Arial, sans-serif;
        }

        .invoice {
            width: 100%;
            max-width: 900px;
            margin: 40px auto;
            padding: 40px;
            background: #fff;
            border-radius: 12px;
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

        .section-title {
            margin-bottom: 12px;
            font-size: 15px;
            font-weight: 700;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            background: #f8f9fa;
            font-size: 13px;
            white-space: nowrap;
        }

        .table td {
            font-size: 14px;
        }

        .total-box {
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .total-price {
            font-size: 25px;
            font-weight: 800;
            text-align: right;
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

        .invoice-note {
            font-size: 13px;
            line-height: 1.6;
        }

        @media print {
            @page {
                size: A4;
                margin: 12mm;
            }

            body {
                background: #fff !important;
                color: #212529 !important;
                font-size: 12px;
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }

            .invoice {
                width: 100%;
                max-width: 100%;
                margin: 0;
                padding: 0;
                border-radius: 0;
                box-shadow: none;
            }

            .no-print {
                display: none !important;
            }

            .table-responsive {
                overflow: visible !important;
            }

            .table {
                width: 100%;
                page-break-inside: auto;
            }

            .table tr,
            .total-box {
                page-break-inside: avoid;
                break-inside: avoid;
            }

            .section-title {
                page-break-after: avoid;
                break-after: avoid;
            }

            a {
                color: inherit !important;
                text-decoration: none !important;
            }
        }

        @media (max-width: 576px) {
            .invoice {
                margin: 12px;
                width: auto;
                padding: 20px;
                border-radius: 8px;
            }

            .brand {
                font-size: 26px;
            }

            .total-price {
                font-size: 20px;
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

        $fulfillmentLabels = [
            'pickup' => 'Ambil di Toko',
            'delivery' => 'Pengiriman',
        ];

        $paymentMethodLabels = [
            'bank_transfer' => 'Transfer Bank',
            'qris' => 'QRIS',
            'ewallet' => 'E-Wallet',
        ];

        $createdAt = $order->created_at;
    @endphp

    <main class="invoice">

        {{-- Header Invoice --}}
        <header class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
            <div>
                <div class="brand">CORE</div>
                <div class="muted small">Computer Hardware Store</div>
            </div>

            <div class="text-md-end">
                <h4 class="fw-bold mb-2">INVOICE</h4>

                <div class="muted small">Nomor pesanan</div>
                <div class="fw-bold">
                    {{ $order->order_number }}
                </div>

                <div class="muted small mt-2">Tanggal pesanan</div>
                <div class="fw-semibold">
                    {{ $createdAt ? $createdAt->format('d M Y, H:i') . ' WIB' : '-' }}
                </div>
            </div>
        </header>

        <hr>

        {{-- Informasi Pelanggan dan Pembayaran --}}
        <section class="row g-4 my-3">

            <div class="col-md-6">
                <div class="section-title">INFORMASI PELANGGAN</div>

                <div class="fw-bold">
                    {{ $order->customer_name }}
                </div>

                <div class="muted">
                    {{ $order->whatsapp }}
                </div>

                <div class="mt-3">
                    <div class="muted small">Metode pemenuhan</div>
                    <div>
                        {{ $fulfillmentLabels[$order->fulfillment_method] ?? $order->fulfillment_method }}
                    </div>
                </div>

                @if ($order->fulfillment_method === 'delivery')
                    <div class="mt-2">
                        <div class="muted small">Alamat pengiriman</div>
                        <div>
                            {{ $order->address ?: '-' }}
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-6">
                <div class="section-title">INFORMASI PEMBAYARAN</div>

                <div class="mb-2">
                    <div class="muted small">Metode pembayaran</div>
                    <div>
                        {{ $paymentMethodLabels[$order->payment_method] ?? $order->payment_method }}
                    </div>
                </div>

                <div class="mb-2">
                    <div class="muted small">Status pembayaran</div>

                    @if ($order->payment_status === 'paid')
                        <span class="badge text-bg-success">
                            {{ $paymentLabels[$order->payment_status] }}
                        </span>
                    @else
                        <span class="badge text-bg-warning">
                            {{ $paymentLabels[$order->payment_status] ?? $order->payment_status }}
                        </span>
                    @endif
                </div>

                <div>
                    <div class="muted small">Status pesanan</div>

                    <span class="status {{ $order->status === 'cancelled' ? 'status-cancelled' : '' }}">
                        {{ $statusLabels[$order->status] ?? $order->status }}
                    </span>
                </div>
            </div>

        </section>

        {{-- Rincian Produk --}}
        <section class="mt-4">
            <div class="section-title">RINCIAN PRODUK</div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Harga Satuan</th>
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
                                    Rp {{ number_format((float) $item->unit_price, 0, ',', '.') }}
                                </td>

                                <td class="text-end">
                                    Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center muted">
                                    Tidak ada rincian produk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Total Pembayaran --}}
        <section class="row justify-content-end mt-4">
            <div class="col-md-7 col-lg-6">
                <div class="total-box">
                    <div class="d-flex justify-content-between align-items-center gap-3">
                        <span class="muted">Total Pembayaran</span>

                        <span class="total-price">
                            Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="muted small mt-2">
                        Total sesuai rincian pesanan saat checkout.
                    </div>
                </div>
            </div>
        </section>

        {{-- Catatan Invoice --}}
        <footer class="mt-4 pt-3 border-top">
            <div class="fw-bold mb-1">
                Terima kasih telah berbelanja di CORE!
            </div>

            <div class="muted invoice-note">
                Simpan invoice ini sebagai referensi rincian pesanan Anda.
                Status pembayaran dan pesanan mengikuti data terbaru di sistem CORE.
            </div>
        </footer>

        {{-- Tombol Aksi: tidak ikut dicetak --}}
        <div class="d-flex flex-wrap gap-2 mt-4 no-print">
            <button
                type="button"
                onclick="window.print()"
                class="btn btn-dark"
            >
                Cetak / Simpan PDF
            </button>

            <a
                href="{{ route('checkout.success', [
                    'orderNumber' => $order->order_number,
                    'accessToken' => $order->access_token,
                ]) }}"
                class="btn btn-outline-secondary"
            >
                Kembali ke Pesanan
            </a>

            <a
                href="{{ route('home') }}"
                class="btn btn-outline-primary"
            >
                Kembali ke Beranda
            </a>
        </div>

    </main>
</body>
</html>