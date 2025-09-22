@php
    $isHeroPage = request()->routeIs('home', 'about');
@endphp

<header x-data="{
    navIsScrolled: !{{ Js::from($isHeroPage) }} || window.scrollY > 50,
    isMobileMenuOpen: false
}"
    @scroll.window.debounce.50ms="if ({{ Js::from($isHeroPage) }}) navIsScrolled = window.scrollY > 50"
    :class="{
        'bg-white/95 backdrop-blur-sm shadow-sm border-gray-200 text-persada-dark': navIsScrolled,
        'border-transparent text-white': !navIsScrolled
    }"
    class="fixed top-0 left-0 w-full z-50 transition-all duration-300 flex items-center h-24 border-b">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="flex justify-between items-center">
            <a href="{{ route('home') }}">
                <img :src="navIsScrolled ? '{{ asset('images/company-logo-dark.png') }}' :
                    '{{ asset('images/company-logo-white.png') }}'"
                    alt="Persada Packaging" class="h-10 md:h-12 w-auto">
            </a>

            <nav class="hidden md:flex items-center gap-12 text-sm font-semibold tracking-wider uppercase">
                <a href="{{ route('home') }}"
                    :class="{
                        'border-persada-dark': navIsScrolled && {{ request()->routeIs('home') ? 'true' : 'false' }},
                        'border-white': !navIsScrolled && {{ request()->routeIs('home') ? 'true' : 'false' }},
                        'border-transparent': !{{ request()->routeIs('home') ? 'true' : 'false' }},
                        'hover:border-persada-dark': navIsScrolled,
                        'hover:border-white': !navIsScrolled
                    }"
                    class="border-b-2 pb-1 transition-colors duration-300">Beranda</a>
                <a href="{{ route('products.index') }}"
                    :class="{
                        'border-persada-dark': {{ request()->is('products*') ? 'true' : 'false' }},
                        'border-transparent': !{{ request()->is('products*') ? 'true' : 'false' }},
                        'hover:border-persada-dark': navIsScrolled,
                        'hover:border-white': !navIsScrolled
                    }"
                    class="border-b-2 pb-1 transition-colors duration-300">Produk</a>
                <a href="{{ route('about') }}"
                    :class="{
                        'border-persada-dark': navIsScrolled && {{ request()->routeIs('about') ? 'true' : 'false' }},
                        'border-white': !navIsScrolled && {{ request()->routeIs('about') ? 'true' : 'false' }},
                        'border-transparent': !{{ request()->routeIs('about') ? 'true' : 'false' }},
                        'hover:border-persada-dark': navIsScrolled,
                        'hover:border-white': !navIsScrolled
                    }"
                    class="border-b-2 pb-1 transition-colors duration-300">Tentang Kami</a>
            </nav>

            <div class="flex items-center gap-x-5">
                @auth
                    <a href="{{ route('cart.index') }}" title="Keranjang Belanja"
                        class="flex items-center transition-colors"
                        :class="navIsScrolled ? 'hover:text-persada-primary' : 'hover:text-gray-200'">
                        <x-heroicon-o-shopping-bag class="h-6 w-6" />
                    </a>

                    <div x-data="{ open: false }" @click.away="open = false" class="relative">
                        <button @click="open = !open" type="button"
                            class="flex rounded-full text-sm focus:outline-none focus:text-persada-primary transition-colors"
                            :class="{
                                'hover:text-persada-primary': navIsScrolled,
                                'hover:text-gray-200':
                                    !navIsScrolled
                            }">

                            <span class="sr-only">Buka menu pengguna</span>
                            <x-heroicon-o-user class="h-6 w-6" />
                        </button>

                        <div x-show="open" x-cloak x-transition
                            class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-xl bg-white shadow-lg">
                            <div class="py-2">
                                <a href="{{ route('customer.profile.index') }}"
                                    class="group flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-persada-primary">
                                    <x-heroicon-o-user-circle
                                        class="mr-3 h-5 w-5 text-gray-400 group-hover:text-persada-primary" />
                                    Akun Saya
                                </a>
                                <a href="{{ route('orders.index') }}"
                                    class="group flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-persada-primary">
                                    <x-heroicon-o-shopping-bag
                                        class="mr-3 h-5 w-5 text-gray-400 group-hover:text-persada-primary" />
                                    Pesanan Saya
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="group flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-persada-primary">
                                        <x-heroicon-o-power
                                            class="mr-3 h-5 w-5 text-gray-400 group-hover:text-persada-primary" />
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="hidden md:inline-block font-semibold py-2 px-5 rounded-full text-sm transition-colors duration-300"
                        :class="navIsScrolled ? 'bg-persada-primary text-white hover:bg-persada-dark' :
                            'bg-white text-persada-primary hover:bg-gray-200'">
                        Masuk
                    </a>
                @endguest

                <div class="md:hidden flex items-center">
                    <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="flex items-center focus:outline-none">
                        <span class="sr-only">Buka menu</span>
                        <x-heroicon-o-bars-3 class="h-6 w-6" />
                    </button>
                </div>
            </div>

        </div>
    </div>

    <div x-show="isMobileMenuOpen" x-cloak x-transition.opacity.duration.300ms
        class="fixed inset-0 z-[100] bg-white h-screen w-screen md:hidden flex flex-col">
        <div class="flex justify-between items-center px-4 sm:px-6 h-24">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/company-logo-dark.png') }}" alt="Persada Packaging" class="h-10 w-auto">
            </a>
            <button @click="isMobileMenuOpen = false">
                <x-heroicon-o-x-mark class="h-7 w-7 text-gray-700" />
            </button>
        </div>

        <div class="flex-1 flex flex-col justify-center items-center">
            <nav class="flex flex-col items-center space-y-8 text-center">
                <a href="{{ route('home') }}" @click="isMobileMenuOpen = false"
                    class="text-xl font-medium {{ request()->routeIs('home') ? 'text-persada-primary' : 'text-gray-800' }}">
                    Beranda
                </a>
                <a href="{{ route('products.index') }}" @click="isMobileMenuOpen = false"
                    class="text-xl font-medium {{ request()->is('products*') ? 'text-persada-primary' : 'text-gray-800' }}">
                    Produk
                </a>
                <a href="{{ route('about') }}" @click="isMobileMenuOpen = false"
                    class="text-xl font-medium {{ request()->routeIs('about') ? 'text-persada-primary' : 'text-gray-800' }}">
                    Tentang Kami
                </a>
            </nav>
        </div>

        @guest
            <div class="px-8 pb-10">
                <a href="{{ route('login') }}"
                    class="block w-full text-center bg-persada-primary text-white font-semibold py-3 px-4 rounded-full text-lg">
                    Masuk
                </a>
            </div>
        @endguest
    </div>

</header>
