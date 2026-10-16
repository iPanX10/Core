@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card border-0 shadow-sm mx-auto" style="max-width: 700px;">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="display-4 text-success mb-2">✓</div>
                <h2 class="fw-bold">Pesanan Berhasil Dibuat!</h2>
                <p class="text-secondary">
                    Simpan nomor pesanan ini untuk memeriksa pesananmu.
                </p>
            </div>

            <div class="bg-light rounded p-3 mb-4 text-center">
                <div class="text-secondary small">Nomor Pesanan</div>
                <h4 class="fw-bold mb-0">{{ $order->order_number }}</h4>
            </div>

            <h5 class="fw-bold">Informasi Pesanan</h5>

            <div class="d-flex justify-content-between py-2 border-bottom">
                <span>Nama pembeli</span>
                <strong>{{ $order->customer_name }}</strong>
            </div>

            <div class="d-flex justify-content-between py-2 border-bottom">
                <span>WhatsApp</span>
                <strong>{{ $order->whatsapp }}</strong>
            </div>

            <div class="d-flex justify-content-between py-2 border-bottom">
                <span>Penerimaan</span>
                <strong>
                    {{ $order->fulfillment_method === 'delivery'
                        ? 'Pengiriman'
                        : 'Ambil langsung' }}
                </strong>
            </div>

            @if ($order->fulfillment_method === 'delivery')
                <div class="py-2 border-bottom">
                    <div class="text-secondary small">Alamat pengiriman</div>
                    <div>{{ $order->address }}</div>
                </div>
            @endif

            <div class="d-flex justify-content-between py-2 border-bottom">
                <span>Metode pembayaran</span>
                <strong>
                    @switch($order->payment_method)
                        @case('bank_transfer')
                            Transfer Bank / VA
                            @break
                        @case('qris')
                            QRIS
                            @break
                        @case('ewallet')
                            E-wallet
                            @break
                    @endswitch
                </strong>
            </div>

            <div class="d-flex justify-content-between py-2 border-bottom">
                <span>Status pesanan</span>
                <span class="badge text-bg-warning">Menunggu proses</span>
            </div>

            <div class="d-flex justify-content-between py-2 border-bottom">
                <span>Status pembayaran</span>
                <span class="badge text-bg-secondary">Belum dibayar</span>
            </div>

            <h5 class="fw-bold mt-4">Rincian Produk</h5>

            @foreach ($order->items as $item)
                <div class="d-flex justify-content-between gap-3 py-2 border-bottom">
                    <div>
                        {{ $item->product_name }}
                        <div class="text-secondary small">
                            {{ $item->quantity }} ×
                            Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                        </div>
                    </div>

                    <strong>
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </strong>
                </div>
            @endforeach

            <div class="d-flex justify-content-between mt-3 mb-4">
                <h5 class="fw-bold">Total</h5>
                <h5 class="fw-bold">
                    Rp {{ number_format($order->total, 0, ',', '.') }}
                </h5>
            </div>

            <div class="alert alert-info small">
                Ini merupakan checkout simulasi. Pesanan belum dibayar dan
                belum ada transaksi uang sungguhan.
            </div>

            <a href="{{ route('home') }}" class="btn btn-dark w-100">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection