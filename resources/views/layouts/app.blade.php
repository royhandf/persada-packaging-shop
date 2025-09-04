<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Persada Packaging')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-persada-dark font-sans">
    <header id="navbar"
        class="fixed top-0 left-0 w-full z-50 transition-[background-color,border-color] duration-300 text-white h-24 flex items-center border-b border-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="flex justify-between items-center">
                <a href="/">
                    <img id="navbar-logo" src="{{ asset('images/company-logo-white.png') }}" alt="Persada Packaging"
                        class="h-10 w-auto transition-all duration-300">
                </a>

                <nav id="nav-links" class="hidden md:flex items-center gap-12">
                    <a href="#"
                        class="border-b-2 border-white pb-1 transition-[border-color] duration-300">Home</a>
                    <a href="#"
                        class="border-b-2 border-transparent hover:border-white pb-1 transition-[border-color] duration-300">Products</a>
                    <a href="#"
                        class="border-b-2 border-transparent hover:border-white pb-1 transition-[border-color] duration-300">About
                        Us</a>
                </nav>

                <div id="nav-icons" class="hidden md:flex items-center space-x-6">
                    <a href="#"><x-heroicon-o-shopping-bag class="h-6 w-6" /></a>
                    <a href="#"><x-heroicon-o-user class="h-6 w-6" /></a>
                </div>

                <div class="md:hidden">
                    <button><x-heroicon-o-bars-3 class="h-7 w-7" /></button>
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-persada-dark text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <a href="/">
                        <img src="{{ asset('images/company-logo-white.png') }}" alt="logo"
                            class="max-h-20 w-auto mb-5">
                    </a>
                    <p class="text-sm text-gray-300 max-w-xs mb-6">
                        Our vision to redefine elegance and sophistication in beauty packaging.
                    </p>
                    <div class="flex items-center space-x-4">
                        <a href="#" class="text-persada-accent hover:text-white transition" title="Instagram">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"></svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="text-sm font-bold tracking-wider text-persada-accent uppercase mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-300 hover:text-persada-accent transition">Home</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-persada-accent transition">Products</a>
                        </li>
                        <li><a href="#" class="text-gray-300 hover:text-persada-accent transition">About Us</a>
                        </li>
                        <li><a href="#" class="text-gray-300 hover:text-persada-accent transition">Contact</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-sm font-bold tracking-wider text-persada-accent uppercase mb-4">Contact Us</h4>
                    <div class="space-y-3 text-gray-300 text-sm">
                        <p class="flex items-start">
                            <x-heroicon-o-building-office-2
                                class="w-5 h-5 text-persada-accent mr-3 mt-0.5 flex-shrink-0" />
                            <span>PT Persada Jayaraya Abadi</span>
                        </p>
                        <p class="flex items-start">
                            <x-heroicon-o-map-pin class="w-5 h-5 text-persada-accent mr-3 mt-0.5 flex-shrink-0" />
                            <a href="https://maps.app.goo.gl/t4XGV8UDjLbdknAZ9" target="_blank"
                                rel="noopener noreferrer" class="hover:text-persada-accent transition">
                                Kahuripan Avenue no 23 Sidoarjo
                            </a>
                        </p>

                        <p>
                            <a href="tel:+6281283635368"
                                class="inline-flex items-start hover:text-persada-accent transition">
                                <x-heroicon-o-phone class="w-5 h-5 text-persada-accent mr-3 mt-0.5 flex-shrink-0" />
                                <span>+62 812-8363-5368</span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 pt-6 mt-10 text-center">
                <p class="text-xs text-gray-400">
                    &copy; {{ date('Y') }} Persada Packaging. All Rights Reserved.
                </p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const navbar = document.getElementById("navbar");
            const logo = document.getElementById("navbar-logo");
            const navLinks = document.querySelectorAll("#nav-links a");

            if (!navbar || !logo || !navLinks) return;

            const whiteLogoSrc = "{{ asset('images/company-logo-white.png') }}".replace(window.location.origin, "");
            const darkLogoSrc = "{{ asset('images/company-logo-dark.png') }}".replace(window.location.origin, "");

            const handleScroll = () => {
                if (window.scrollY > 50) {
                    navbar.classList.add("bg-white/80", "backdrop-blur-sm", "border-gray-200",
                        "text-persada-dark");
                    navbar.classList.remove("text-white", "border-transparent");
                    logo.src = darkLogoSrc;

                    navLinks.forEach((link, index) => {
                        if (index === 0) {
                            link.classList.add("border-persada-dark");
                            link.classList.remove("border-white");
                        } else {
                            link.classList.add("hover:border-persada-dark");
                            link.classList.remove("hover:border-white");
                        }
                    });

                } else {
                    navbar.classList.remove("bg-white/80", "backdrop-blur-sm", "border-gray-200",
                        "text-persada-dark");
                    navbar.classList.add("text-white",
                        "border-transparent");
                    logo.src = whiteLogoSrc;

                    navLinks.forEach((link, index) => {
                        if (index === 0) {
                            link.classList.remove("border-persada-dark");
                            link.classList.add("border-white");
                        } else {
                            link.classList.remove("hover:border-persada-dark");
                            link.classList.add("hover:border-white");
                        }
                    });
                }
            };

            window.addEventListener("scroll", handleScroll);
        });
    </script>
</body>

</html>
