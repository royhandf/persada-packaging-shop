<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/company-logo.ico') }}">
    @if (request()->routeIs('home'))
        <link rel="preload" as="image" href="{{ asset('images/hero-background.jpg') }}">
    @elseif(request()->routeIs('about'))
        <link rel="preload" as="image" href="{{ asset('images/skincare-shades.jpg') }}">
    @endif
    <title>@yield('title', 'Persada Packaging')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-gray-50 text-persada-dark font-sans" x-data="{ isMobileMenuOpen: false }"
    :class="{ 'overflow-hidden': isMobileMenuOpen }">

    @include('layouts.partials.app-header')

    <main>
        @yield('content')
    </main>

    @include('layouts.partials.app-footer')

    @stack('scripts')
</body>

</html>
