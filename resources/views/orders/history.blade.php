<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Riwayat Pesanan | CORE</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        :root {
            --core-dark: #23272e;
            --core-dark-soft: #2c323b;
            --core-silver: #c6cdd6;
            --core-muted: #77818f;
            --core-border: #e1e5eb;
            --core-bg: #f2f4f7;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            padding: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(
                    circle at 10% 10%,
                    #ffffff 0,
                    transparent 38%
                ),
                var(--core-bg);
            color: var(--core-dark);
            font-family: Arial, Helvetica, sans-serif;
        }

        .history-shell {
            display: grid;
            grid-template-columns: 0.88fr 1.12fr;
            width: 100%;
            max-width: 1050px;
            min-height: 610px;
            overflow: hidden;
            background: #fff;
            border: 1px solid rgba(220, 225, 232, .9);
            border-radius: 24px;
            box-shadow: 0 24px 70px rgba(35, 39, 46, .10);
        }

        /* LEFT PANEL */

        .history-visual {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-width: 0;
            padding: 38px;
            overflow: hidden;
            color: #fff;
            background:
                radial-gradient(
                    circle at 80% 55%,
                    rgba(167, 180, 197, .15),
                    transparent 40%
                ),
                linear-gradient(145deg, #20242b, #303741);
        }

        .history-visual::before {
            position: absolute;
            top: 180px;
            left: -100px;
            width: 300px;
            height: 300px;
            content: "";
            border: 1px solid rgba(255, 255, 255, .07);
            border-radius: 50%;
            box-shadow:
                0 0 0 35px rgba(255, 255, 255, .025),
                0 0 0 75px rgba(255, 255, 255, .02);
            pointer-events: none;
        }

        .history-brand {
            position: relative;
            z-index: 1;
            color: #fff;
            font-size: 2rem;
            font-weight: 900;
            letter-spacing: 3px;
            text-decoration: none;
        }

        .history-brand span {
            color: #aeb8c5;
        }

        .history-brand-subtitle {
            margin-top: 3px;
            color: #aeb7c2;
            font-size: .76rem;
            letter-spacing: 1px;
        }

        .history-visual-content {
            position: relative;
            z-index: 1;
            margin-top: 28px;
        }

        .history-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 15px;
            color: #c6cdd6;
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: 2.2px;
        }

        .history-eyebrow::before {
            width: 24px;
            height: 2px;
            content: "";
            background: #aeb8c5;
        }

        .history-visual h1 {
            max-width: 360px;
            margin: 0 0 16px;
            font-size: clamp(2rem, 3.2vw, 2.9rem);
            font-weight: 800;
            letter-spacing: -1.6px;
            line-height: 1.12;
        }

        .history-visual-description {
            max-width: 330px;
            margin-bottom: 0;
            color: #b7c0cb;
            font-size: .94rem;
            line-height: 1.8;
        }

        /* HARDWARE ILLUSTRATION */

        .history-hardware {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 370px;
            margin: 18px auto 24px;
            filter: drop-shadow(0 18px 22px rgba(0, 0, 0, .2));
        }

        .history-hardware svg {
            display: block;
            width: 100%;
            height: auto;
        }

        .history-visual-footer {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, .13);
            color: #b7c0cb;
            font-size: .78rem;
        }

        .history-visual-footer svg {
            flex-shrink: 0;
        }

        /* RIGHT PANEL */

        .history-form-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-width: 0;
            padding: 48px;
        }

        .history-mobile-brand {
            display: none;
        }

        .history-form-eyebrow {
            margin-bottom: 10px;
            color: #7c8795;
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .history-form-title {
            margin: 0 0 12px;
            color: var(--core-dark);
            font-size: clamp(1.8rem, 3vw, 2.3rem);
            font-weight: 800;
            letter-spacing: -1px;
        }

        .history-form-description {
            margin-bottom: 30px;
            color: var(--core-muted);
            font-size: .94rem;
            line-height: 1.75;
        }

        .history-field {
            margin-bottom: 21px;
        }

        .history-label {
            display: block;
            margin-bottom: 9px;
            color: #303640;
            font-size: .88rem;
            font-weight: 700;
        }

        .history-input-wrap {
            position: relative;
        }

        .history-input-icon {
            position: absolute;
            top: 50%;
            left: 15px;
            width: 22px;
            height: 22px;
            color: #87919e;
            transform: translateY(-50%);
            pointer-events: none;
            flex-shrink: 0;
        }

        .history-input {
            display: block;
            width: 100%;
            min-height: 54px;
            padding: 13px 15px 13px 45px;
            color: #252a31;
            background: #fff;
            border: 1px solid #dce1e8;
            border-radius: 10px;
            outline: none;
            font-size: .91rem;
            transition:
                border-color .2s ease,
                box-shadow .2s ease;
        }

        .history-input::placeholder {
            color: #a0a8b3;
        }

        .history-input:hover {
            border-color: #b9c1cc;
        }

        .history-input:focus {
            border-color: #737e8c;
            box-shadow: 0 0 0 4px rgba(115, 126, 140, .12);
        }

        .history-error {
            margin-bottom: 22px;
            padding: 13px 15px;
            color: #9f2929;
            background: #fff2f2;
            border: 1px solid #f0cece;
            border-radius: 10px;
            font-size: .86rem;
            line-height: 1.6;
        }

        .history-submit {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            min-height: 54px;
            margin-top: 5px;
            padding: 14px 18px;
            color: #fff;
            background: var(--core-dark);
            border: 1px solid var(--core-dark);
            border-radius: 10px;
            font-size: .94rem;
            font-weight: 700;
            cursor: pointer;
            transition:
                background .2s ease,
                transform .2s ease,
                box-shadow .2s ease;
        }

        .history-submit:hover {
            color: #fff;
            background: #363d47;
            border-color: #363d47;
            box-shadow: 0 8px 20px rgba(35, 39, 46, .16);
            transform: translateY(-1px);
        }

        .history-submit svg {
            transition: transform .2s ease;
        }

        .history-submit:hover svg {
            transform: translateX(4px);
        }

        .history-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 25px;
            color: #737e8c;
            font-size: .87rem;
            text-decoration: none;
            transition: color .2s ease;
        }

        .history-back:hover {
            color: #23272e;
        }

        .history-help {
            display: flex;
            align-items: flex-start;
            gap: 11px;
            margin-top: 30px;
            padding: 15px;
            background: #f5f6f8;
            border: 1px solid #eaedf1;
            border-radius: 12px;
        }

        .history-help-icon {
            flex-shrink: 0;
            color: #596473;
        }

        .history-help-title {
            margin-bottom: 4px;
            color: #3c434d;
            font-size: .81rem;
            font-weight: 700;
        }

        .history-help-text {
            margin: 0;
            color: #7a8491;
            font-size: .78rem;
            line-height: 1.65;
        }

        /* RESPONSIVE */

        @media (max-width: 900px) {
            body {
                padding: 24px;
            }

            .history-shell {
                grid-template-columns: .85fr 1.15fr;
            }

            .history-visual {
                padding: 30px;
            }

            .history-form-panel {
                padding: 35px;
            }
        }

        @media (max-width: 680px) {
            body {
                display: block;
                padding: 16px;
            }

            .history-shell {
                display: flex;
                flex-direction: column;
                max-width: 480px;
                min-height: auto;
                margin: 12px auto;
                border-radius: 19px;
            }

            .history-visual {
                min-height: auto;
                padding: 25px 25px 22px;
            }

            .history-brand {
                font-size: 1.65rem;
            }

            .history-visual-content {
                margin-top: 26px;
            }

            .history-visual h1 {
                max-width: 320px;
                font-size: 2rem;
            }

            .history-visual-description {
                font-size: .88rem;
            }

            .history-hardware {
                max-width: 280px;
                margin: 12px auto;
            }

            .history-visual-footer {
                padding-top: 14px;
            }

            .history-form-panel {
                padding: 30px 24px;
            }

            .history-form-title {
                font-size: 1.85rem;
            }

            .history-form-description {
                margin-bottom: 24px;
            }

            .history-help {
                margin-top: 24px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>

<body>
    <main class="history-shell">

        <!-- PANEL KIRI: BRAND DAN ILUSTRASI HARDWARE -->
        <section class="history-visual">

            <div>
                <a href="{{ route('home') }}" class="history-brand">
                    CORE<span>.</span>
                </a>

                <div class="history-brand-subtitle">
                    COMPUTER HARDWARE STORE
                </div>
            </div>

            <div class="history-visual-content">
                <div class="history-eyebrow">
                    ORDER TRACKING / 01
                </div>

                <h1>
                    Pesananmu,
                    <br>
                    dalam kendali.
                </h1>

                <p class="history-visual-description">
                    Temukan informasi pesanan hardware kamu
                    dengan mudah melalui satu halaman.
                </p>

                <!-- Ilustrasi SVG hardware, tidak membutuhkan file gambar tambahan -->
                <div class="history-hardware">
                    <svg
                        viewBox="0 0 380 270"
                        xmlns="http://www.w3.org/2000/svg"
                        role="img"
                        aria-label="Ilustrasi monitor komputer, keyboard, dan komponen hardware"
                    >
                        <defs>
                            <linearGradient id="monitorFrame" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0" stop-color="#f4f6f8"/>
                                <stop offset="1" stop-color="#aeb7c3"/>
                            </linearGradient>

                            <linearGradient id="monitorScreen" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0" stop-color="#3e4857"/>
                                <stop offset="1" stop-color="#151a21"/>
                            </linearGradient>

                            <linearGradient id="keyboardBody" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0" stop-color="#dce1e7"/>
                                <stop offset="1" stop-color="#858f9d"/>
                            </linearGradient>

                            <linearGradient id="chipBody" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0" stop-color="#bfc8d2"/>
                                <stop offset="1" stop-color="#707b89"/>
                            </linearGradient>
                        </defs>

                        <!-- Latar ilustrasi -->
                        <ellipse
                            cx="190"
                            cy="232"
                            rx="160"
                            ry="18"
                            fill="#10141a"
                            opacity=".35"
                        />

                        <!-- Motherboard dekoratif di belakang -->
                        <g transform="translate(232 34) rotate(9)">
                            <rect
                                x="0" y="0" width="105" height="115" rx="8"
                                fill="#39424e"
                                stroke="#778392"
                                stroke-width="1.5"
                            />
                            <path
                                d="M14 17H42V35H68V15H89
                                   M16 48H37V65H17
                                   M68 52H89V79H61V99H34"
                                fill="none"
                                stroke="#8994a2"
                                stroke-width="2"
                                opacity=".75"
                            />
                            <rect x="37" y="40" width="32" height="32" rx="4"
                                  fill="url(#chipBody)" stroke="#e0e5ea"/>
                            <rect x="43" y="46" width="20" height="20" rx="2"
                                  fill="#343b45"/>
                            <g fill="#c0a977">
                                <rect x="12" y="27" width="4" height="12" rx="1"/>
                                <rect x="12" y="45" width="4" height="12" rx="1"/>
                                <rect x="12" y="63" width="4" height="12" rx="1"/>
                                <rect x="79" y="85" width="4" height="12" rx="1"/>
                            </g>
                        </g>

                        <!-- Monitor -->
                        <g>
                            <rect
                                x="42" y="20" width="215" height="147" rx="10"
                                fill="url(#monitorFrame)"
                                stroke="#dbe0e6"
                                stroke-width="2"
                            />

                            <rect
                                x="51" y="29" width="197" height="128" rx="5"
                                fill="url(#monitorScreen)"
                            />

                            <!-- Abstraksi visual layar -->
                            <circle cx="147" cy="88" r="48" fill="#657487" opacity=".16"/>
                            <circle cx="147" cy="88" r="35" fill="none"
                                    stroke="#aab5c2" stroke-width="1.5" opacity=".8"/>
                            <circle cx="147" cy="88" r="24" fill="none"
                                    stroke="#d0d7df" stroke-width="1.5" opacity=".8"/>
                            <circle cx="147" cy="88" r="10" fill="#c6cdd6"/>
                            <path d="M147 47V65 M147 111V129 M106 88H124 M170 88H188"
                                  stroke="#d0d7df" stroke-width="2" stroke-linecap="round"/>
                            <path d="M65 42L94 42 M65 49L83 49"
                                  stroke="#aeb8c5" stroke-width="2" stroke-linecap="round" opacity=".8"/>

                            <!-- Kaki monitor -->
                            <path d="M130 167H168L179 197H119Z" fill="#aeb7c3"/>
                            <path d="M109 198H190L201 207H98Z" fill="url(#monitorFrame)"/>
                        </g>

                        <!-- Keyboard di depan -->
                        <g transform="translate(80 177) rotate(-5)">
                            <path
                                d="M8 0H220L240 53Q241 59 233 61H0Q-7 59-4 52Z"
                                fill="url(#keyboardBody)"
                                stroke="#dce1e7"
                                stroke-width="1.5"
                            />

                            <g fill="#353c46" stroke="#626d7b" stroke-width=".7">
                                <rect x="9" y="8" width="20" height="11" rx="2"/>
                                <rect x="34" y="8" width="20" height="11" rx="2"/>
                                <rect x="59" y="8" width="20" height="11" rx="2"/>
                                <rect x="84" y="8" width="20" height="11" rx="2"/>
                                <rect x="109" y="8" width="20" height="11" rx="2"/>
                                <rect x="134" y="8" width="20" height="11" rx="2"/>
                                <rect x="159" y="8" width="20" height="11" rx="2"/>
                                <rect x="184" y="8" width="20" height="11" rx="2"/>
                                <rect x="209" y="8" width="17" height="11" rx="2"/>

                                <rect x="12" y="24" width="24" height="11" rx="2"/>
                                <rect x="41" y="24" width="24" height="11" rx="2"/>
                                <rect x="70" y="24" width="24" height="11" rx="2"/>
                                <rect x="99" y="24" width="24" height="11" rx="2"/>
                                <rect x="128" y="24" width="24" height="11" rx="2"/>
                                <rect x="157" y="24" width="24" height="11" rx="2"/>
                                <rect x="186" y="24" width="34" height="11" rx="2"/>

                                <rect x="18" y="40" width="29" height="10" rx="2"/>
                                <rect x="52" y="40" width="29" height="10" rx="2"/>
                                <rect x="86" y="40" width="66" height="10" rx="2"/>
                                <rect x="157" y="40" width="29" height="10" rx="2"/>
                                <rect x="191" y="40" width="29" height="10" rx="2"/>
                            </g>

                            <!-- Tombol aksen silver -->
                            <rect x="159" y="40" width="29" height="10" rx="2" fill="#c1c9d3"/>
                        </g>

                        <!-- Chip prosesor di kanan bawah -->
                        <g transform="translate(291 164) rotate(9)">
                            <rect x="0" y="0" width="52" height="52" rx="7"
                                  fill="#c1c9d3" stroke="#e6eaf0" stroke-width="2"/>
                            <rect x="8" y="8" width="36" height="36" rx="4"
                                  fill="#343b45"/>
                            <rect x="15" y="15" width="22" height="22" rx="2"
                                  fill="url(#chipBody)"/>
                            <g stroke="#d0b77e" stroke-width="2" stroke-linecap="round">
                                <path d="M10 -4V0 M20 -4V0 M30 -4V0 M40 -4V0"/>
                                <path d="M10 52V56 M20 52V56 M30 52V56 M40 52V56"/>
                                <path d="M-4 10H0 M-4 20H0 M-4 30H0 M-4 40H0"/>
                                <path d="M52 10H56 M52 20H56 M52 30H56 M52 40H56"/>
                            </g>
                        </g>
                    </svg>
                </div>
            </div>

            <div class="history-visual-footer">
                <svg
                    width="18" height="18" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="1.7"
                    aria-hidden="true"
                >
                    <path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11Z"/>
                    <path d="m9 12 2 2 4-4"/>
                </svg>
                Pencarian pesanan dengan verifikasi data checkout
            </div>
        </section>

        <!-- PANEL KANAN: FORM PENCARIAN -->
        <section class="history-form-panel">

            <div class="history-mobile-brand">
                <a href="{{ route('home') }}" class="history-brand">
                    CORE<span>.</span>
                </a>
                <div class="history-brand-subtitle">
                    COMPUTER HARDWARE STORE
                </div>
            </div>

            <div class="history-form-eyebrow">
                My Orders
            </div>

            <h2 class="history-form-title">
                Cari Pesanan
            </h2>

            <p class="history-form-description">
                Masukkan nomor pesanan dan nomor WhatsApp
                yang digunakan saat checkout untuk melihat
                informasi pesananmu.
            </p>

            @if ($errors->any())
                <div class="history-error" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Route, method, CSRF, nama input dan old value dipertahankan -->
            <form
                action="{{ route('orders.history.search') }}"
                method="POST"
            >
                @csrf

                <div class="history-field">
                    <label for="order_number" class="history-label">
                        Nomor Pesanan
                    </label>

                    <div class="history-input-wrap">
                        <svg
                            class="history-input-icon"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                            aria-hidden="true"
                        >
                            <rect x="4" y="3" width="16" height="18" rx="2"/>
                            <path d="M8 7h8M8 11h8M8 15h5"/>
                        </svg>

                        <input
                            type="text"
                            id="order_number"
                            name="order_number"
                            class="history-input"
                            placeholder="Contoh: CORE-XXXXXXXXXX"
                            value="{{ old('order_number') }}"
                            maxlength="50"
                            autocomplete="off"
                            required
                        >
                    </div>
                </div>

                <div class="history-field">
                    <label for="whatsapp" class="history-label">
                        Nomor WhatsApp
                    </label>

                    <div class="history-input-wrap">
                        <svg
                            class="history-input-icon"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                            aria-hidden="true"
                        >
                            <path d="M21 11.5a8.4 8.4 0 0 1-12.4 7.4L3 20l1.2-5.3A8.4 8.4 0 1 1 21 11.5Z"/>
                            <path d="M8.5 8.5c.5 2 2 3.5 4 4l1.2-1.2 2 1c-.2 1.2-1 2-2.2 2-3.2-.3-6.5-3.6-6.8-6.8 0-1.2.8-2 2-2.2l1 2Z"/>
                        </svg>

                        <input
                            type="tel"
                            id="whatsapp"
                            name="whatsapp"
                            class="history-input"
                            placeholder="Contoh: 081234567890"
                            value="{{ old('whatsapp') }}"
                            maxlength="20"
                            autocomplete="tel"
                            required
                        >
                    </div>
                </div>

                <button type="submit" class="history-submit">
                    <span>Cari Pesanan</span>

                    <svg
                        width="19" height="19"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        aria-hidden="true"
                    >
                        <path d="M5 12h14M13 6l6 6-6 6"/>
                    </svg>
                </button>
            </form>

            <div class="history-help">
                <svg
                    class="history-help-icon"
                    width="21" height="21"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                    aria-hidden="true"
                >
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 11v5M12 8h.01"/>
                </svg>

                <div>
                    <div class="history-help-title">
                        Pastikan data sudah benar
                    </div>

                    <p class="history-help-text">
                        Gunakan nomor pesanan dan nomor WhatsApp
                        yang sama seperti saat checkout.
                    </p>
                </div>
            </div>

            <div class="text-center">
                <a
                    href="{{ route('home') }}"
                    class="history-back"
                >
                    <svg
                        width="17" height="17"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        aria-hidden="true"
                    >
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>

                    Kembali ke Beranda
                </a>
            </div>

        </section>
    </main>
</body>
</html>