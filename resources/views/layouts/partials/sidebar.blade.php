<aside id="sidebar"
    class="fixed top-0 left-0 z-40 flex h-screen w-72 flex-col transition-transform duration-300 ease-in-out lg:translate-x-0 border-r border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

    <div class="px-6 py-6 text-center">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/company-logo-dark.png') }}" alt="Persada Logo"
                class="mx-auto h-10 block dark:hidden">
            <img src="{{ asset('images/company-logo-white.png') }}" alt="Persada Logo"
                class="mx-auto h-10 hidden dark:block">
        </a>
    </div>

    <nav class="flex-grow space-y-1 p-4 overflow-y-auto scrollbar-hide">
        {{-- Variabel untuk Cek Active State Halaman --}}
        @php
            $isDashboard = request()->routeIs('dashboard');
            $isProfil = request()->routeIs('profile');
            $isPesanan = request()->is('dashboard/orders*');
            $isDataMaster = request()->is('dashboard/master/*');
            $isLaporan = request()->is('dashboard/laporan/*');
            $isManajemenAdmin = request()->is('dashboard/teams*');
            $isPengaturan = request()->is('dashboard/settings*');
        @endphp

        {{-- =============================================== --}}
        {{-- MENU UTAMA & OPERASIONAL --}}
        {{-- =============================================== --}}
        <p class="px-3 pt-2 pb-1 text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">Menu
            Utama</p>

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition-colors {{ $isDashboard ? 'bg-green-100 text-green-700 shadow-sm dark:bg-green-900/50 dark:text-green-400' : 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
            <x-heroicon-o-home class="h-5 w-5" />
            <span>Dashboard</span>
        </a>

        <a href="{{ route('dashboard.orders.index') }}"
            class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition-colors {{ $isPesanan ? 'bg-green-100 text-green-700 shadow-sm dark:bg-green-900/50 dark:text-green-400' : 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
            <x-heroicon-o-shopping-bag class="h-5 w-5" />
            <span>Pesanan</span>
        </a>

        {{-- Profil Akun --}}
        <a href="{{ route('profile') }}"
            class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition-colors {{ $isProfil ? 'bg-green-100 text-green-700 shadow-sm dark:bg-green-900/50 dark:text-green-400' : 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
            <x-heroicon-o-user-circle class="h-5 w-5" />
            <span>Profil Akun</span>
        </a>

        <div class="rounded-lg {{ $isDataMaster ? 'bg-green-50 dark:bg-green-900/30' : '' }}">
            <button @click="dataMasterOpen = !dataMasterOpen"
                class="flex w-full items-center justify-between gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition-colors {{ $isDataMaster ? 'text-green-700 dark:text-green-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white' }}">
                <span class="flex items-center gap-3">
                    <x-heroicon-o-circle-stack class="h-5 w-5" />
                    <span>Data Master</span>
                </span>
                <x-heroicon-s-chevron-down class="h-5 w-5 transition-transform"
                    x-bind:class="dataMasterOpen ? 'rotate-180' : ''" />
            </button>

            <ul x-show="dataMasterOpen" x-transition
                class="mt-2 ml-5 space-y-1 border-l-2 pl-4 {{ $isDataMaster ? 'border-green-200 dark:border-green-800' : 'border-gray-200 dark:border-gray-700' }}"
                x-cloak>
                <li>
                    <a href="{{ route('master.products.index') }}"
                        class="block rounded-md px-4 py-2 text-sm font-medium transition-colors {{ request()->routeIs('master.products.*') ? 'text-green-700 font-semibold dark:text-green-400' : 'text-gray-500 hover:text-green-600 dark:text-gray-400 dark:hover:text-green-400' }}">
                        Produk
                    </a>
                </li>
                <li>
                    <a href="{{ route('master.categories.index') }}"
                        class="block rounded-md px-4 py-2 text-sm font-medium transition-colors {{ request()->routeIs('master.categories.*') ? 'text-green-700 font-semibold dark:text-green-400' : 'text-gray-500 hover:text-green-600 dark:text-gray-400 dark:hover:text-green-400' }}">
                        Kategori
                    </a>
                </li>
                <li>
                    <a href="{{ route('master.customers.index') }}"
                        class="block rounded-md px-4 py-2 text-sm font-medium transition-colors {{ request()->is('dashboard/master/customers*') ? 'text-green-700 font-semibold dark:text-green-400' : 'text-gray-500 hover:text-green-600 dark:text-gray-400 dark:hover:text-green-400' }}">
                        Pelanggan
                    </a>
                </li>
            </ul>
        </div>

        {{-- =============================================== --}}
        {{-- SUPER ADMIN --}}
        {{-- =============================================== --}}
        @if (auth()->user()->role === 'superadmin')
            <p class="px-3 pt-4 pb-1 text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">
                Super Admin</p>

            {{-- Menu Laporan --}}
            <div class="rounded-lg {{ $isLaporan ? 'bg-green-50 dark:bg-green-900/30' : '' }}">
                <button @click="laporanOpen = !laporanOpen"
                    class="flex w-full items-center justify-between gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition-colors {{ $isLaporan ? 'text-green-700 dark:text-green-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white' }}">
                    <span class="flex items-center gap-3">
                        <x-heroicon-o-document-chart-bar class="h-5 w-5" />
                        <span>Laporan</span>
                    </span>
                    <x-heroicon-s-chevron-down class="h-5 w-5 transition-transform"
                        x-bind:class="laporanOpen ? 'rotate-180' : ''" />
                </button>

                <ul x-show="laporanOpen" x-transition
                    class="mt-2 ml-5 space-y-1 border-l-2 pl-4 {{ $isLaporan ? 'border-green-200 dark:border-green-800' : 'border-gray-200 dark:border-gray-700' }}"
                    x-cloak>
                    <li>
                        <a href="{{ route('laporan.penjualan.index') }}"
                            class="block rounded-md px-4 py-2 text-sm font-medium transition-colors {{ request()->routeIs('laporan.penjualan.*') ? 'text-green-700 font-semibold dark:text-green-400' : 'text-gray-500 hover:text-green-600 dark:text-gray-400 dark:hover:text-green-400' }}">
                            Penjualan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('laporan.pelanggan.index') }}"
                            class="block rounded-md px-4 py-2 text-sm font-medium transition-colors {{ request()->routeIs('laporan.pelanggan.*') ? 'text-green-700 font-semibold dark:text-green-400' : 'text-gray-500 hover:text-green-600 dark:text-gray-400 dark:hover:text-green-400' }}">
                            Pelanggan
                        </a>
                    </li>
                </ul>
            </div>

            <a href="{{ route('teams.index') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition-colors {{ $isManajemenAdmin ? 'bg-green-100 text-green-700 shadow-sm dark:bg-green-900/50 dark:text-green-400' : 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                <x-heroicon-o-users class="h-5 w-5" />
                <span>Manajemen Admin</span>
            </a>

            <a href="{{ route('settings.index') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition-colors {{ $isPengaturan ? 'bg-green-100 text-green-700 shadow-sm dark:bg-green-900/50 dark:text-green-400' : 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                <x-heroicon-o-cog-6-tooth class="h-5 w-5" />
                <span>Pengaturan Toko</span>
            </a>
        @endif
    </nav>
</aside>
