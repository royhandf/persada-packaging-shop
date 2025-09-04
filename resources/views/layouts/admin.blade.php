<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/company-logo.ico') }}">
    <title>@yield('title', 'Dashboard') - Persada Packaging</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 text-gray-900">

    <div x-data="{
        sidebarOpen: false,
        dataMasterOpen: {{ request()->is('master*') ? 'true' : 'false' }},
        laporanOpen: {{ request()->is('laporan*') ? 'true' : 'false' }}
    }" class="flex h-screen overflow-hidden">

        @include('layouts.partials.sidebar')

        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-30 lg:hidden" x-cloak>
        </div>

        <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden lg:ml-72">
            @include('layouts.partials.header')

            <main class="p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
