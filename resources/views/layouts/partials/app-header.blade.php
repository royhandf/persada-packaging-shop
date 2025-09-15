@php
    $isHeroPage = request()->routeIs('home') || request()->routeIs('about');

    $isHomeActive = request()->routeIs('home');
    $isProductsActive = request()->is('products*');
    $isAboutActive = request()->routeIs('about');
@endphp

<header x-data="{
    isHeroPage: {{ Illuminate\Support\Js::from($isHeroPage) }},
    navIsScrolled: !{{ Illuminate\Support\Js::from($isHeroPage) }}
}" x-init="if (isHeroPage) {
    navIsScrolled = window.scrollY > 50;
}"
    @scroll.window.debounce.50ms="
        if (isHeroPage) {
            navIsScrolled = window.scrollY > 50;
        }
    "
    :class="{
        'bg-white/95 backdrop-blur-sm shadow-sm border-gray-200 text-persada-dark': navIsScrolled,
        'border-transparent text-white': !navIsScrolled
    }"
    class="fixed top-0 left-0 w-full z-50 transition-all duration-300 flex items-center h-24 border-b">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="flex justify-between items-center">
            <a href="/">
                <img :src="navIsScrolled ? '{{ asset('images/company-logo-dark.png') }}' :
                    '{{ asset('images/company-logo-white.png') }}'"
                    alt="Persada Packaging" class="h-10 md:h-12 w-auto transition-all duration-300">
            </a>

            <nav class="hidden md:flex items-center gap-12">
                <a href="{{ route('home') }}"
                    :class="{
                        'border-persada-dark': navIsScrolled && {{ Illuminate\Support\Js::from($isHomeActive) }},
                        'border-white': !navIsScrolled && {{ Illuminate\Support\Js::from($isHomeActive) }},
                        'border-transparent': !{{ Illuminate\Support\Js::from($isHomeActive) }},
                        'hover:border-persada-dark': navIsScrolled,
                        'hover:border-white': !navIsScrolled
                    }"
                    class="border-b-2 pb-1 transition-colors duration-300">
                    Beranda
                </a>
                <a href="{{ route('products.index') }}"
                    :class="{
                        'border-persada-dark': navIsScrolled && {{ Illuminate\Support\Js::from($isProductsActive) }},
                        'border-white': !navIsScrolled && {{ Illuminate\Support\Js::from($isProductsActive) }},
                        'border-transparent': !{{ Illuminate\Support\Js::from($isProductsActive) }},
                        'hover:border-persada-dark': navIsScrolled,
                        'hover:border-white': !navIsScrolled
                    }"
                    class="border-b-2 pb-1 transition-colors duration-300">
                    Produk
                </a>
                <a href="{{ route('about') }}"
                    :class="{
                        'border-persada-dark': navIsScrolled && {{ Illuminate\Support\Js::from($isAboutActive) }},
                        'border-white': !navIsScrolled && {{ Illuminate\Support\Js::from($isAboutActive) }},
                        'border-transparent': !{{ Illuminate\Support\Js::from($isAboutActive) }},
                        'hover:border-persada-dark': navIsScrolled,
                        'hover:border-white': !navIsScrolled
                    }"
                    class="border-b-2 pb-1 transition-colors duration-300">
                    Tentang Kami
                </a>
            </nav>

            <div class="hidden md:flex items-center space-x-6">
                @auth
                    <a href="#" title="Keranjang Belanja"
                        :class="{ 'hover:text-persada-primary': navIsScrolled, 'hover:text-gray-200': !navIsScrolled }">
                        <x-heroicon-o-shopping-bag class="h-6 w-6" />
                    </a>
                    <a href="#" title="Profil Anda"
                        :class="{ 'hover:text-persada-primary': navIsScrolled, 'hover:text-gray-200': !navIsScrolled }">
                        <x-heroicon-o-user class="h-6 w-6" />
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        :class="{
                            'bg-persada-primary text-white hover:bg-persada-dark': navIsScrolled,
                            'bg-white text-persada-primary hover:bg-gray-200': !navIsScrolled
                        }"
                        class="inline-block font-semibold py-2 px-5 rounded-full text-sm transition-colors duration-300">
                        Masuk
                    </a>
                @endguest
            </div>

            <div class="md:hidden">
                <button @click="isMobileMenuOpen = true" class="focus:outline-none">
                    <span class="sr-only">Buka menu</span>
                    <x-heroicon-o-bars-3 class="h-7 w-7" />
                </button>
            </div>
        </div>
    </div>
</header>

<div x-show="isMobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed inset-0 bg-white z-[100] md:hidden">
    <div class="w-full h-full flex flex-col">
        <div class="flex justify-between items-center px-4 sm:px-6 h-24">
            <a href="/">
                <img src="{{ asset('images/company-logo-dark.png') }}" alt="Persada Packaging" class="h-10 w-auto">
            </a>
            <button @click="isMobileMenuOpen = false">
                <span class="sr-only">Tutup menu</span>
                <x-heroicon-o-x-mark class="h-7 w-7 text-gray-700" />
            </button>
        </div>
        <div class="flex-grow flex flex-col justify-center items-center -mt-12">
            <nav class="flex flex-col items-center space-y-8 text-center">
                <a href="{{ route('home') }}" @click="isMobileMenuOpen = false"
                    class="text-xl font-medium {{ $isHomeActive ? 'text-persada-primary' : 'text-persada-dark' }}">Beranda</a>
                <a href="{{ route('products.index') }}" @click="isMobileMenuOpen = false"
                    class="text-xl font-medium {{ $isProductsActive ? 'text-persada-primary' : 'text-persada-dark' }}">Produk</a>
                <a href="{{ route('about') }}" @click="isMobileMenuOpen = false"
                    class="text-xl font-medium {{ $isAboutActive ? 'text-persada-primary' : 'text-persada-dark' }}">Tentang
                    Kami</a>
                @auth
                    <a href="#" @click="isMobileMenuOpen = false"
                        class="text-xl font-medium text-persada-dark">Keranjang Belanja</a>
                    <a href="#" @click="isMobileMenuOpen = false" class="text-xl font-medium text-persada-dark">Profil
                        Anda</a>
                @endauth
            </nav>
            @guest
                <div class="mt-12 w-full px-8">
                    <a href="{{ route('login') }}"
                        class="block w-full text-center bg-persada-primary text-white font-semibold py-3 px-4 rounded-full text-lg">Masuk</a>
                </div>
            @endguest
        </div>
    </div>
</div>
