<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'CORE — Computer Hardware Store')</title>

    <meta
        name="description"
        content="@yield('meta_description', 'Temukan kebutuhan komputer dan hardware di CORE.')"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="{{ asset('css/core.css') }}">

    <style>
        html,
        body {
            min-height: 100%;
            margin: 0;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        #main-content {
            flex: 1 0 auto;
        }

        #kontak {
            flex-shrink: 0;
            margin-top: 0 !important;
        }
    </style>

    @stack('styles')
</head>
<body>
    @include('components.navbar')

    <main id="main-content">
        @yield('content')
    </main>

    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>