<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/company-logo.ico') }}">
    <title>@yield('title', 'Dashboard') - Persada Packaging</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="font-sans antialiased bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-200">
    <div x-data="{
        sidebarOpen: false,
        profileDropdownOpen: false,
        manajemenTokoOpen: {{ request()->is('dashboard/penjualan*') ? 'true' : 'false' }},
        dataMasterOpen: {{ request()->is('dashboard/master*') ? 'true' : 'false' }},
        laporanOpen: {{ request()->is('dashboard/reports*') ? 'true' : 'false' }}
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

    @if (session('success') || session('error'))
        <script>
            window.addEventListener("DOMContentLoaded", () => {
                Swal.fire({
                    icon: '{{ session('success') ? 'success' : 'error' }}',
                    title: '{{ session('success') ? 'Sukses' : 'Error' }}',
                    text: '{{ session('success') ?? session('error') }}',
                    timer: 2500,
                    background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#fff',
                    color: document.documentElement.classList.contains('dark') ? '#e5e7eb' : '#111827',
                    showConfirmButton: false,
                });
            });
        </script>
    @endif

    @stack('scripts')
</body>

</html>
