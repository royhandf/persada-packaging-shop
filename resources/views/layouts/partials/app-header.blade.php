@php
    $isHeroPage = request()->routeIs('home') || request()->routeIs('about');

    $isHomeActive = request()->routeIs('home');
    $isProductsActive = request()->is('products*');
    $isAboutActive = request()->routeIs('about');
@endphp

<header x-data="{
    isHeroPage: {{ Illuminate\Support\Js::from($isHeroPage) }},
    isScrolled: !{{ Illuminate\Support\Js::from($isHeroPage) }} || window.scrollY > 50
}" @scroll.window.throttle.100ms="if (isHeroPage) isScrolled = window.scrollY > 50"
    :class="{
        'bg-white/95 backdrop-blur-sm border-b border-gray-200 text-persada-dark': isScrolled,
        'shadow-sm': isScrolled && isHeroPage,
        'text-white border-b border-transparent': !isScrolled
    }"
    class="fixed top-0 left-0 w-full z-50 transition-all duration-300 flex items-center h-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="flex justify-between items-center">
            <a href="/">
                <img :src="isScrolled ? '{{ asset('images/company-logo-dark.png') }}' :
                    '{{ asset('images/company-logo-white.png') }}'"
                    alt="Persada Packaging" class="h-10 md:h-12 w-auto transition-all duration-300">
            </a>

            <nav class="hidden md:flex items-center gap-12">
                <a href="{{ route('home') }}"
                    :class="{
                        'border-persada-dark': isScrolled && {{ Illuminate\Support\Js::from($isHomeActive) }},
                        'border-white': !isScrolled && {{ Illuminate\Support\Js::from($isHomeActive) }},
                        'hover:border-persada-dark': isScrolled,
                        'hover:border-white': !isScrolled,
                        'border-transparent': !{{ Illuminate\Support\Js::from($isHomeActive) }}
                    }"
                    class="border-b-2 pb-1 transition-colors duration-300">
                    Beranda
                </a>
                <a href="{{ route('products.index') }}"
                    :class="{
                        'border-persada-dark': {{ Illuminate\Support\Js::from($isProductsActive) }},
                        'hover:border-persada-dark': isScrolled,
                        'hover:border-white': !isScrolled,
                        'border-transparent': !{{ Illuminate\Support\Js::from($isProductsActive) }}
                    }"
                    class="border-b-2 pb-1 transition-colors duration-300">
                    Produk
                </a>
                <a href="{{ route('about') }}"
                    :class="{
                        'border-persada-dark': isScrolled && {{ Illuminate\Support\Js::from($isAboutActive) }},
                        'border-white': !isScrolled && {{ Illuminate\Support\Js::from($isAboutActive) }},
                        'hover:border-persada-dark': isScrolled,
                        'hover:border-white': !isScrolled,
                        'border-transparent': !{{ Illuminate\Support\Js::from($isAboutActive) }}
                    }"
                    class="border-b-2 pb-1 transition-colors duration-300">
                    Tentang Kami
                </a>
            </nav>

            <div class="hidden md:flex items-center space-x-6">
                @auth
                    <a href="" title="Keranjang Belanja"
                        :class="{ 'hover:text-persada-primary': isScrolled, 'hover:text-gray-200': !isScrolled }">
                        <x-heroicon-o-shopping-bag class="h-6 w-6" />
                    </a>
                    <a href="" title="Profil Anda"
                        :class="{ 'hover:text-persada-primary': isScrolled, 'hover:text-gray-200': !isScrolled }">
                        <x-heroicon-o-user class="h-6 w-6" />
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        :class="{
                            'bg-persada-primary text-white hover:bg-persada-dark': isScrolled,
                            'bg-white text-persada-primary hover:bg-gray-200': !isScrolled
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
                    class="text-xl font-medium {{ request()->routeIs('home') ? 'text-persada-primary' : 'text-persada-dark' }}">Beranda</a>
                <a href="{{ route('products.index') }}" @click="isMobileMenuOpen = false"
                    class="text-xl font-medium {{ request()->is('products*') ? 'text-persada-primary' : 'text-persada-dark' }}">Produk</a>
                <a href="{{ route('about') }}" @click="isMobileMenuOpen = false"
                    class="text-xl font-medium {{ request()->is('about*') ? 'text-persada-primary' : 'text-persada-dark' }}">Tentang
                    Kami</a>
                @auth
                    <a href="#" @click="isMobileMenuOpen = false"
                        class="text-xl font-medium {{ request()->is('cart*') ? 'text-persada-primary' : 'text-persada-dark' }}">Keranjang
                        Belanja</a>
                    <a href="#" @click="isMobileMenuOpen = false"
                        class="text-xl font-medium {{ request()->is('profile*') ? 'text-persada-primary' : 'text-persada-dark' }}">Profil
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
