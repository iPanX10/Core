@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card border-0 shadow-sm mx-auto" style="max-width: 760px;">
        <div class="card-body p-4 p-md-5">

            {{-- Header --}}
            <div class="text-center mb-4">
                @if ($order->status === 'cancelled')
                    <div class="display-4 text-danger mb-2">✕</div>
                    <h2 class="fw-bold">Pesanan Dibatalkan</h2>
                    <p class="text-secondary">
                        Pesanan ini telah dibatalkan. Hubungi admin jika membutuhkan bantuan.
                    </p>
                @else
                    <div class="display-4 text-success mb-2">✓</div>
                    <h2 class="fw-bold">Informasi Pesanan CORE</h2>
                    <p class="text-secondary">
                        Pantau perkembangan pesanan melalui halaman ini.
                    </p>
                @endif
            </div>

            {{-- Nomor Pesanan --}}
            <div class="bg-light rounded p-3 mb-4 text-center">
                <div class="text-secondary small">Nomor Pesanan</div>
                <h4 class="fw-bold mb-0">{{ $order->order_number }}</h4>
            </div>

            {{-- Progres Pesanan --}}
            @if ($order->status !== 'cancelled')
                @php
                    // Langkah progres disesuaikan dengan metode penerimaan.
                    $steps = [
                        'pending' => [
                            'label' => 'Menunggu',
                            'description' => 'Pesanan diterima',
                        ],
                        'processing' => [
                            'label' => 'Diproses',
                            'description' => 'Pesanan sedang disiapkan',
                        ],
                    ];

                    // Langkah Dikirim hanya untuk pesanan delivery.
                    if ($order->fulfillment_method === 'delivery') {
                        $steps['shipped'] = [
                            'label' => 'Dikirim',
                            'description' => 'Pesanan dalam pengiriman',
                        ];
                    }

                    // Langkah Selesai selalu tersedia.
                    $steps['completed'] = [
                        'label' => 'Selesai',
                        'description' => $order->fulfillment_method === 'pickup'
                            ? 'Pesanan telah diambil di toko'
                            : 'Pesanan telah selesai',
                    ];

                    $stepOrder = array_keys($steps);
                    $currentIndex = array_search($order->status, $stepOrder, true);
                @endphp

                <h5 class="fw-bold mb-3">Progres Pesanan</h5>

                <div class="border rounded p-3 mb-4">
                    @foreach ($steps as $key => $step)
                        @php
                            $stepIndex = array_search($key, $stepOrder, true);

                            $isCompleted = $currentIndex !== false
                                && $stepIndex < $currentIndex;

                            $isCurrent = $key === $order->status;
                        @endphp

                        <div class="d-flex gap-3 {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="text-center" style="min-width: 32px;">
                                @if ($isCompleted)
                                    <span
                                        class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success text-white"
                                        style="width: 30px; height: 30px;">
                                        ✓
                                    </span>
                                @elseif ($isCurrent)
                                    <span
                                        class="d-inline-flex align-items-center justify-content-center rounded-circle bg-dark text-white"
                                        style="width: 30px; height: 30px;">
                                        {{ $loop->iteration }}
                                    </span>
                                @else
                                    <span
                                        class="d-inline-flex align-items-center justify-content-center rounded-circle border text-secondary"
                                        style="width: 30px; height: 30px;">
                                        {{ $loop->iteration }}
                                    </span>
                                @endif
                            </div>

                            <div>
                                <div class="{{ $isCurrent ? 'fw-bold' : '' }}">
                                    {{ $step['label'] }}

                                    @if ($isCurrent)
                                        <span class="badge text-bg-primary ms-1">
                                            Status saat ini
                                        </span>
                                    @endif
                                </div>

                                <div class="text-secondary small">
                                    {{ $step['description'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-danger">
                    Pesanan ini berstatus <strong>Dibatalkan</strong>.
                    Progres pesanan tidak dapat dilanjutkan.
                </div>
            @endif

            {{-- Informasi Pelanggan --}}
            <h5 class="fw-bold mt-4">Informasi Pelanggan</h5>

            <div class="d-flex justify-content-between gap-3 py-2 border-bottom">
                <span>Nama pembeli</span>
                <strong class="text-end">{{ $order->customer_name }}</strong>
            </div>

            <div class="d-flex justify-content-between gap-3 py-2 border-bottom">
                <span>WhatsApp</span>
                <strong class="text-end">{{ $order->whatsapp }}</strong>
            </div>

            {{-- Informasi Metode Penerimaan --}}
            <div class="d-flex justify-content-between gap-3 py-2 border-bottom">
                <span>Metode penerimaan</span>
                <strong class="text-end">
                    {{ $order->fulfillment_method === 'delivery'
                        ? 'Pengiriman'
                        : 'Ambil langsung di toko' }}
                </strong>
            </div>

            {{-- Alamat hanya ditampilkan untuk delivery --}}
            @if ($order->fulfillment_method === 'delivery')
                <div class="py-2 border-bottom">
                    <div class="text-secondary small">Alamat pengiriman</div>
                    <div>{{ $order->address ?: '-' }}</div>
                </div>
            @endif

            {{-- Metode Pembayaran --}}
            <div class="d-flex justify-content-between gap-3 py-2 border-bottom">
                <span>Metode pembayaran</span>

                <strong class="text-end">
                    @switch($order->payment_method)
                        @case('bank_transfer')
                            Transfer Bank / VA
                            @break

                        @case('qris')
                            QRIS
                            @break

                        @case('ewallet')
                            E-Wallet
                            @break

                        @default
                            {{ ucfirst($order->payment_method) }}
                    @endswitch
                </strong>
            </div>

            {{-- Status Pembayaran --}}
            <div class="d-flex justify-content-between align-items-center gap-3 py-2 border-bottom">
                <span>Status pembayaran</span>

                <span class="badge {{ $order->payment_status === 'paid'
                    ? 'text-bg-success'
                    : 'text-bg-warning' }}">
                    {{ $order->payment_status === 'paid'
                        ? 'Sudah dibayar'
                        : 'Belum dibayar' }}
                </span>
            </div>

            {{-- Instruksi Pembayaran --}}
            @if ($order->status !== 'cancelled' && $order->payment_status === 'unpaid')
                <div class="card border mt-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Instruksi Pembayaran</h5>

                        @switch($order->payment_method)
                            @case('bank_transfer')
                                <div class="alert alert-info">
                                    <strong>Transfer Bank / Virtual Account</strong>
                                    <p class="mb-0 mt-2">
                                        Pembayaran ini masih berupa simulasi.
                                        CORE belum terhubung dengan bank atau
                                        penyedia Virtual Account.
                                    </p>
                                </div>
                                @break

                            @case('qris')
                                <div class="alert alert-info">
                                    <strong>Pembayaran QRIS</strong>
                                    <p class="mb-0 mt-2">
                                        Pembayaran QRIS masih berupa simulasi.
                                        Belum tersedia kode QR pembayaran yang
                                        dapat digunakan untuk transaksi nyata.
                                    </p>
                                </div>
                                @break

                            @case('ewallet')
                                <div class="alert alert-info">
                                    <strong>Pembayaran E-Wallet</strong>
                                    <p class="mb-0 mt-2">
                                        Pembayaran e-wallet masih berupa simulasi
                                        dan belum terhubung dengan penyedia layanan.
                                    </p>
                                </div>
                                @break

                            @default
                                <div class="alert alert-warning">
                                    Silakan hubungi admin untuk informasi pembayaran.
                                </div>
                        @endswitch

                        <div class="d-flex justify-content-between align-items-center gap-3">
                            <span class="text-secondary">Total pembayaran</span>
                            <strong class="fs-5 text-nowrap">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </strong>
                        </div>

                        <p class="text-secondary small mt-3 mb-0">
                            Jangan mengirim uang berdasarkan instruksi simulasi ini.
                            Status pembayaran hanya berubah setelah admin melakukan
                            konfirmasi.
                        </p>
                    </div>
                </div>
            @endif

            {{-- Rincian Produk --}}
            <h5 class="fw-bold mt-4">Rincian Produk</h5>

            @foreach ($order->items as $item)
                <div class="d-flex justify-content-between gap-3 py-2 border-bottom">
                    <div>
                        <div class="fw-medium">{{ $item->product_name }}</div>

                        <div class="text-secondary small">
                            {{ $item->quantity }} ×
                            Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                        </div>
                    </div>

                    <strong class="text-nowrap">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </strong>
                </div>
            @endforeach

            {{-- Total Pesanan --}}
            <div class="d-flex justify-content-between align-items-center mt-3 mb-4">
                <h5 class="fw-bold">Total</h5>

                <h5 class="fw-bold text-nowrap">
                    Rp {{ number_format($order->total, 0, ',', '.') }}
                </h5>
            </div>

            {{-- Keterangan Status --}}
            @if ($order->status === 'cancelled')
                <div class="alert alert-danger small">
                    Pesanan ini telah dibatalkan. Jika kamu sudah melakukan
                    pembayaran, silakan hubungi admin untuk informasi penyelesaian
                    pembayaran atau refund.
                </div>
            @elseif ($order->payment_status === 'unpaid')
                <div class="alert alert-warning small">
                    Pembayaran belum diverifikasi. Checkout CORE masih berupa
                    simulasi dan belum memproses transaksi uang sungguhan.
                </div>
            @else
                <div class="alert alert-success small">
                    Pembayaran telah ditandai lunas oleh admin.
                </div>
            @endif

            <div class="alert alert-info small">
                Status di halaman ini mengikuti data pesanan yang tersimpan.
                Muat ulang halaman untuk melihat perubahan terbaru dari admin.
            </div>

            {{-- Tombol Aksi --}}
            <div class="d-grid gap-2">
                <a
                    href="{{ route('checkout.invoice', [
                        'orderNumber' => $order->order_number,
                        'accessToken' => $order->access_token,
                    ]) }}"
                    class="btn btn-outline-dark">
                    Lihat Invoice
                </a>

                <button
                    type="button"
                    class="btn btn-outline-secondary"
                    onclick="window.location.reload()">
                    Muat Ulang Status
                </button>

                <a href="{{ route('home') }}" class="btn btn-dark">
                    Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>
</div>
@endsection