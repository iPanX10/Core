<nav class="navbar navbar-expand-lg navbar-dark bg-dark core-navbar sticky-top">
    <div class="container">

        {{-- Brand CORE tanpa gambar logo --}}
        <a
            class="navbar-brand fw-bold core-brand"
            href="{{ route('home') }}"
        >
            CORE<span class="core-brand-dot">.</span>
        </a>

        {{-- Tombol navigasi mobile --}}
        <button
            class="navbar-toggler core-toggler"
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
            <ul class="navbar-nav ms-auto align-items-lg-center core-nav-list">

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('home') && !request()->has('section') ? 'active' : '' }}"
                        href="{{ route('home') }}"
                    >
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="{{ route('home') }}#produk"
                    >
                        Produk
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="{{ route('home') }}#lokasi"
                    >
                        Lokasi Toko
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="{{ route('home') }}#kontak"
                    >
                        Kontak
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('orders.history') ? 'active' : '' }}"
                        href="{{ route('orders.history') }}"
                    >
                        Riwayat Pesanan
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link core-cart-link {{ request()->routeIs('cart.*') ? 'active' : '' }}"
                        href="{{ route('cart.index') }}"
                    >
                        Keranjang
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>