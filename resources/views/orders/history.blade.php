<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Riwayat Pesanan | CORE</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
            color: #212529;
            font-family: Arial, sans-serif;
        }

        .history-card {
            max-width: 520px;
            margin: 70px auto;
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

        .form-control {
            padding: 12px;
        }

        @media (max-width: 576px) {
            .history-card {
                margin: 24px 12px;
                padding: 24px;
            }
        }
    </style>
</head>

<body>
    <main class="history-card">
        <div class="text-center mb-4">
            <div class="brand">CORE</div>
            <div class="muted small">Computer Hardware Store</div>

            <h4 class="fw-bold mt-4">Cari Pesanan</h4>

            <p class="muted">
                Masukkan nomor pesanan dan nomor WhatsApp
                yang digunakan saat checkout.
            </p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('orders.history.search') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="order_number" class="form-label fw-semibold">
                    Nomor Pesanan
                </label>

                <input
                    type="text"
                    id="order_number"
                    name="order_number"
                    class="form-control"
                    placeholder="Contoh: CORE-XXXXXXXXXX"
                    value="{{ old('order_number') }}"
                    maxlength="50"
                    required
                >
            </div>

            <div class="mb-4">
                <label for="whatsapp" class="form-label fw-semibold">
                    Nomor WhatsApp
                </label>

                <input
                    type="tel"
                    id="whatsapp"
                    name="whatsapp"
                    class="form-control"
                    placeholder="Contoh: 081234567890"
                    value="{{ old('whatsapp') }}"
                    maxlength="20"
                    required
                >
            </div>

            <button type="submit" class="btn btn-dark w-100 py-2">
                Cari Pesanan
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                &larr; Kembali ke Beranda
            </a>
        </div>
    </main>
</body>
</html>