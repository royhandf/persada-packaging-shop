<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/company-logo.ico') }}">
    <title>@yield('title') - Persada Packaging</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen md:flex @yield('imageOrderClass', '')">

        <div class="relative hidden md:flex md:w-1/2 items-center justify-center p-12 bg-cover bg-center"
            style="background-image: url('{{ asset('images/auth-background.webp') }}');">

            <div class="absolute inset-0 bg-black opacity-50"></div>

            <div class="relative z-10 max-w-md text-center text-white">
                <h1 class="font-display text-4xl font-bold mb-4">
                    Kemasan Sempurna, Merek Impian.
                </h1>
                <p class="text-gray-200 leading-relaxed">
                    Temukan berbagai pilihan kemasan impor berkualitas tinggi untuk mengangkat citra merek produk
                    kecantikan Anda.
                </p>
            </div>
        </div>

        <div class="w-full md:w-1/2 flex flex-col">
            <div class="relative md:hidden h-48 bg-cover bg-center"
                style="background-image: url('{{ asset('images/auth-background.webp') }}');">
                <div class="absolute inset-0 bg-black opacity-50"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <img src="{{ asset('images/company-logo-white.png') }}" alt="Persada Packaging Logo" class="h-12">
                </div>
            </div>

            <div class="flex-grow flex items-center justify-center p-8 sm:p-12">
                <div class="w-full max-w-sm">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    @if (session('auth_success'))
        <script>
            window.addEventListener("DOMContentLoaded", () => {
                window.notyf.success(@json(session('auth_success')));
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            window.addEventListener("DOMContentLoaded", () => {
                window.notyf.error(@json($errors->first()));
            });
        </script>
    @endif

</body>

</html>
