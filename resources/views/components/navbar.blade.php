<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        {{-- Logo CORE --}}
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            CORE
        </a>

        {{-- Tombol navigasi mobile --}}
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarCore"
            aria-controls="navbarCore"
            aria-expanded="false"
            aria-label="Buka navigasi"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Menu navigasi --}}
        <div class="collapse navbar-collapse" id="navbarCore">
            <ul class="navbar-nav ms-auto align-items-lg-center">

                {{-- Home --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        Home
                    </a>
                </li>

                {{-- Produk --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#produk">
                        Produk
                    </a>
                </li>

                {{-- Lokasi Toko --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#lokasi">
                        Lokasi Toko
                    </a>
                </li>

                {{-- Kontak --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#kontak">
                        Kontak
                    </a>
                </li>

                {{-- Riwayat Pesanan --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orders.history') }}">
                        Riwayat Pesanan
                    </a>
                </li>

                {{-- Keranjang --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cart.index') }}">
                        Keranjang
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>