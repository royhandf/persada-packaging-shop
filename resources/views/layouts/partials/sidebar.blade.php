<aside id="sidebar"
    class="bg-white w-72 h-screen fixed top-0 left-0 z-40 flex flex-col transition-transform duration-300 ease-in-out lg:translate-x-0 border-r border-gray-200"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

    <div class="px-6 py-6 text-center border-b border-gray-200">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/company-logo.png') }}" alt="Persada Logo" class="h-10 mx-auto">
        </a>
    </div>

    <nav class="flex-grow p-4 space-y-1">
        @php
            $isDashboard = request()->routeIs('dashboard');
            $isProfil = request()->routeIs('profil');
            $isDataMaster = request()->is('master/*');
            $isLaporan = request()->is('laporan/*');
        @endphp

        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors font-semibold text-sm {{ $isDashboard ? 'bg-persada-primary text-white shadow-sm' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-900' }}">
            <x-heroicon-o-home class="w-5 h-5" />
            <span>Dashboard</span>
        </a>

        <a href=""
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors font-semibold text-sm {{ $isProfil ? 'bg-persada-primary text-white shadow-sm' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-900' }}">
            <x-heroicon-o-user-circle class="w-5 h-5" />
            <span>Profil Akun</span>
        </a>

        <div>
            <button @click="dataMasterOpen = !dataMasterOpen"
                class="w-full flex items-center justify-between gap-3 px-4 py-3 rounded-lg transition-colors font-semibold text-sm {{ $isDataMaster ? 'text-persada-primary' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-900' }}">
                <span class="flex items-center gap-3">
                    <x-heroicon-o-circle-stack class="w-5 h-5" />
                    <span>Data Master</span>
                </span>
                <x-heroicon-s-chevron-down class="w-5 h-5 transition-transform"
                    x-bind:class="dataMasterOpen ? 'rotate-180' : ''" />
            </button>
            <ul x-show="dataMasterOpen" x-transition class="mt-2 ml-5 space-y-1 pl-4 border-l-2 border-gray-200"
                x-cloak>
                <li><a href="#"
                        class="block px-4 py-2 rounded-md text-sm text-gray-500 hover:text-persada-primary font-medium">Kategori</a>
                </li>
                <li><a href="#"
                        class="block px-4 py-2 rounded-md text-sm text-gray-500 hover:text-persada-primary font-medium">Produk</a>
                </li>
                <li><a href="#"
                        class="block px-4 py-2 rounded-md text-sm text-gray-500 hover:text-persada-primary font-medium">Berita</a>
                </li>
            </ul>
        </div>

        <div>
            <button @click="laporanOpen = !laporanOpen"
                class="w-full flex items-center justify-between gap-3 px-4 py-3 rounded-lg transition-colors font-semibold text-sm {{ $isLaporan ? 'text-persada-primary' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-900' }}">
                <span class="flex items-center gap-3">
                    <x-heroicon-o-document-chart-bar class="w-5 h-5" />
                    <span>Laporan</span>
                </span>
                <x-heroicon-s-chevron-down class="w-5 h-5 transition-transform"
                    x-bind:class="laporanOpen ? 'rotate-180' : ''" />
            </button>
            <ul x-show="laporanOpen" x-transition class="mt-2 ml-5 space-y-1 pl-4 border-l-2 border-gray-200" x-cloak>
                <li><a href="#"
                        class="block px-4 py-2 rounded-md text-sm text-gray-500 hover:text-persada-primary font-medium">Data
                        Penjualan</a></li>
                <li><a href="#"
                        class="block px-4 py-2 rounded-md text-sm text-gray-500 hover:text-persada-primary font-medium">Data
                        Pelanggan</a></li>
            </ul>
        </div>
    </nav>


</aside>
