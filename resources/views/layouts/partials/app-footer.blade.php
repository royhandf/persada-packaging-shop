    <footer class="bg-persada-dark">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/company-logo-white.png') }}" alt="logo" class="h-12 w-auto mb-4">
                    </a>
                    <p class="text-sm text-gray-300 max-w-xs">
                        Visi kami untuk mendefinisikan ulang keanggunan dan kecanggihan dalam kemasan kecantikan.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-200 uppercase tracking-wider mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a></li>
                        <li><a href="{{ route('products.index') }}" class="hover:text-white transition">Produk</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-white transition">Tentang Kami</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-200 uppercase tracking-wider mb-4">Hubungi Kami</h4>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li class="flex items-start">
                            <x-heroicon-o-building-office-2 class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" />
                            <span>PT Persada Jayaraya Abadi</span>
                        </li>
                        <li class="flex items-start">
                            <x-heroicon-o-map-pin class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" />
                            <a href="https://www.google.com/maps?q=Kahuripan+Avenue+no+23+Sidoarjo" target="_blank"
                                rel="noopener noreferrer" class="hover:text-white transition">
                                Kahuripan Avenue no 23 Sidoarjo
                            </a>
                        </li>
                        <li>
                            <a href="tel:+6281283635368" class="inline-flex items-start hover:text-white transition">
                                <x-heroicon-o-phone class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" />
                                <span>+62 812-8363-5368</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-persada-dark-hover py-8 mt-8 text-center">
                <p class="text-xs text-gray-400">
                    © {{ date('Y') }} Persada Packaging. All Rights Reserved.
                </p>
            </div>
        </div>
    </footer>
