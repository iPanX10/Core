<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokasi Toko | CORE</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/core.css') }}">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">CORE.</a>
        <a href="{{ url('/') }}" class="btn btn-outline-light btn-sm">
            Kembali ke Beranda
        </a>
    </div>
</nav>

<main class="container py-5">
    <div class="mb-4">
        <p class="text-secondary mb-1">KUNJUNGI KAMI</p>
        <h1 class="fw-bold">Lokasi Toko CORE</h1>
        <p class="text-secondary">
            Temukan lokasi toko kami dan kunjungi langsung untuk kebutuhan
            hardware komputer kamu.
        </p>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4">Informasi Toko</h4>

                    <h6 class="fw-bold">Alamat</h6>
                    <p>
                        Jl. Margonda Raya No. 100, Pondok Cina,
                        Kecamatan Beji, Kota Depok, Jawa Barat 16424
                    </p>

                    <hr>

                    <h6 class="fw-bold">Jam Operasional</h6>
                    <p>Senin–Sabtu, 09.00–20.00 WIB</p>

                    <hr>

                    <h6 class="fw-bold">Kontak WhatsApp</h6>
                    <p>+62 851-2330-0335</p>

                    <a
                        href="https://maps.app.goo.gl/CqyiLS13sY4DoE8XA"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="btn btn-dark w-100 mt-3">
                        Petunjuk Arah di Google Maps
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="rounded-3 overflow-hidden border"
                 style="min-height: 420px;">
                <iframe
                    src="https://maps.google.com/maps?q=Jl.%20Margonda%20Raya%20No.100%2C%20Depok%2C%20Jawa%20Barat&t=&z=16&ie=UTF8&iwloc=&output=embed"
                    width="100%"
                    height="420"
                    style="border:0;"
                    loading="lazy"
                    allowfullscreen
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Peta lokasi toko CORE">
                </iframe>
            </div>
        </div>
    </div>
</main>

<footer class="bg-dark text-white text-center py-3">
    <small>&copy; {{ date('Y') }} CORE. All rights reserved.</small>
</footer>

</body>
</html>