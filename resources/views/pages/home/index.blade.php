@extends('layouts.app')

@section('title', 'Beranda - Persada Packaging')

@section('content')
    <section class="relative h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/10 z-10"></div>
            <img class="object-cover w-full h-full" src="{{ asset('images/hero-background.jpg') }}"
                alt="Premium cosmetic packaging background" loading="eager">
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full z-20" x-data="{ show: false }"
            x-init="setTimeout(() => show = true, 300)">
            <div class="max-w-3xl text-white text-center mx-auto">
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-display font-bold" x-show="show"
                    x-transition:enter="transition ease-out duration-1000"
                    x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                    Persada Packaging
                </h1>
                <p class="mt-6 text-lg md:text-xl" x-show="show"
                    x-transition:enter="transition ease-out duration-1000 delay-300"
                    x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                    Kami adalah partner Anda dalam menciptakan kemasan kosmetik premium yang tidak hanya melindungi, tapi
                    juga menceritakan kisah brand Anda.
                </p>
                <div class="mt-10" x-show="show" x-transition:enter="transition ease-out duration-1000 delay-500"
                    x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                    <a href="{{ route('products.index') }}"
                        class="inline-block bg-persada-primary text-white font-semibold py-3 px-8 rounded-full text-lg hover:bg-white hover:text-persada-primary transition-all duration-300 transform hover:scale-105">
                        Produk Kami
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="philosophy" class="bg-white py-20 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                <div class="text-left" x-data x-intersect:enter.once="$el.classList.add('animate-fade-in-right')">
                    <h2 class="text-base font-semibold text-persada-primary tracking-wider uppercase">Filosofi Kami</h2>
                    <p class="mt-2 text-3xl font-display font-bold text-persada-dark tracking-tight sm:text-4xl">
                        Kemasan yang Memajukan Merek Anda
                    </p>
                    <p class="mt-6 text-lg text-gray-600">
                        Kami percaya kemasan adalah duta pertama brand Anda. Filosofi kami berakar pada tiga pilar inovasi
                        yang mendorong brand partner kami untuk maju dan dicintai konsumen.
                    </p>
                </div>
                <div class="mt-12 lg:mt-0 grid grid-cols-1 gap-10" x-data
                    x-intersect:enter.once="$el.classList.add('animate-fade-in-left')">
                    <div class="flex items-start">
                        <div
                            class="flex-shrink-0 h-12 w-12 rounded-full bg-persada-primary/10 flex items-center justify-center text-persada-primary">
                            <x-heroicon-o-sparkles class="h-6 w-6" />
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-persada-dark">Inovasi Berkesadaran</h3>
                            <p class="mt-1 text-gray-600">Inovasi desain yang sadar akan tren, fungsionalitas, dan estetika
                                untuk menciptakan kemasan yang relevan dan diinginkan.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div
                            class="flex-shrink-0 h-12 w-12 rounded-full bg-persada-primary/10 flex items-center justify-center text-persada-primary">
                            <x-heroicon-o-globe-alt class="h-6 w-6" />
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-persada-dark">Bahan Baku Berkelanjutan</h3>
                            <p class="mt-1 text-gray-600">Pilihan material yang berkelanjutan dan terkurasi, dari bahan daur
                                ulang hingga inovasi ramah lingkungan untuk masa depan yang lebih baik.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div
                            class="flex-shrink-0 h-12 w-12 rounded-full bg-persada-primary/10 flex items-center justify-center text-persada-primary">
                            <x-heroicon-o-user-group class="h-6 w-6" />
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-persada-dark">Kemitraan Kolaboratif</h3>
                            <p class="mt-1 text-gray-600">Kami bukan supplier, kami adalah partner. Kami berkolaborasi di
                                setiap langkah untuk memastikan visi Anda terwujud dengan sempurna.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="new-products" class="bg-gray-50 py-20 sm:py-24 overflow-hidden" x-data="horizontalSlider()">
        <div class="max-w-7xl mx-auto">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-end mb-12">
                    <div class="text-left">
                        <h2 class="text-base font-semibold text-persada-primary tracking-wider uppercase">Inovasi Terbaru
                        </h2>
                        <p class="mt-2 text-3xl font-display font-bold text-persada-dark tracking-tight sm:text-4xl">Koleksi
                            Produk Baru Kami</p>
                    </div>
                    <div class="hidden sm:flex items-center gap-x-2">
                        <button @click="prev()" aria-label="Previous slide"
                            class="w-10 h-10 rounded-full bg-white shadow-md flex items-center justify-center text-gray-600 hover:bg-gray-100 transition"><x-heroicon-o-arrow-left
                                class="w-5 h-5" /></button>
                        <button @click="next()" aria-label="Next slide"
                            class="w-10 h-10 rounded-full bg-white shadow-md flex items-center justify-center text-gray-600 hover:bg-gray-100 transition"><x-heroicon-o-arrow-right
                                class="w-5 h-5" /></button>
                    </div>
                </div>
            </div>
            <div class="relative">
                <div x-ref="slider" class="flex gap-8 overflow-x-auto pb-8 no-scrollbar cursor-grab px-4 sm:px-6 lg:px-8">
                    @foreach ($products as $product)
                        <div class="flex-shrink-0 w-72 md:w-80 group">
                            <x-product-card :product="$product" />
                        </div>
                    @endforeach
                    <div class="flex-shrink-0 w-72 md:w-80 flex items-center justify-center">
                        <a href="{{ route('products.index') }}"
                            class="group flex items-center justify-center w-full h-full border-2 border-dashed border-gray-300 rounded-2xl hover:border-persada-primary hover:bg-persada-primary/5 transition-all duration-300">
                            <div class="text-center text-gray-500 group-hover:text-persada-primary">
                                <x-heroicon-o-arrow-right-circle class="h-12 w-12 mx-auto" />
                                <p class="mt-2 font-semibold">Lihat Semua Produk</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-20 sm:py-24" x-data="horizontalSlider()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div class="mx-auto text-center max-w-2xl">
                    <h2 class="text-base font-semibold text-persada-primary tracking-wider uppercase">Testimonial</h2>
                    <p class="mt-2 text-3xl font-bold font-display tracking-tight text-gray-900 sm:text-4xl">Apa Kata Klien
                        Kami</p>
                </div>
            </div>
            <div class="relative">
                <div x-ref="slider"
                    class="flex gap-8 overflow-x-auto pb-8 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 no-scrollbar cursor-grab">
                    @php
                        $testimonials = [
                            [
                                'name' => 'Sarah L.',
                                'title' => 'Founder, GlowUp Cosmetics',
                                'img' => '1',
                                'text' =>
                                    'Kualitas kemasannya luar biasa, benar-benar mengangkat citra produk kami. Tim Persada Packaging juga sangat membantu selama proses kustomisasi. Sangat direkomendasikan!',
                            ],
                            [
                                'name' => 'Budi S.',
                                'title' => 'Owner, Nature Essence',
                                'img' => '2',
                                'text' =>
                                    'MOQ yang fleksibel sangat membantu kami sebagai brand yang baru mulai. Kami bisa memesan dalam jumlah kecil dulu tanpa mengorbankan kualitas. Terima kasih Persada!',
                            ],
                            [
                                'name' => 'Rina W.',
                                'title' => 'Product Manager, Belleza Skincare',
                                'img' => '3',
                                'text' =>
                                    'Respon timnya cepat dan prosesnya sangat transparan. Mulai dari pemilihan bahan sampai pengiriman, semuanya berjalan lancar. Pasti akan order lagi untuk koleksi berikutnya.',
                            ],
                            [
                                'name' => 'David K.',
                                'title' => 'CEO, Manhood Grooming',
                                'img' => '4',
                                'text' =>
                                    'Desainnya elegan dan modern. Produk kami jadi terlihat lebih premium di pasaran. Proses pemesanan juga sangat mudah dan efisien.',
                            ],
                            [
                                'name' => 'Clara T.',
                                'title' => 'Head of Procurement, Aura Beauty',
                                'img' => '5',
                                'text' =>
                                    'Sebagai partner jangka panjang, Persada Packaging tidak pernah mengecewakan. Kualitas konsisten dan pengiriman selalu tepat waktu.',
                            ],
                            [
                                'name' => 'Aditya P.',
                                'title' => 'Startup Founder',
                                'img' => '6',
                                'text' =>
                                    'Pilihan bahan ramah lingkungan menjadi nilai plus bagi brand kami. Pelanggan kami mengapresiasi pilihan kemasan yang berkelanjutan.',
                            ],
                        ];
                    @endphp
                    @foreach ($testimonials as $testimonial)
                        <div class="flex-shrink-0 w-[90%] sm:w-1/2 lg:w-[32%]">
                            <figure class="rounded-2xl bg-gray-50 p-8 ring-1 ring-gray-900/5 h-full flex flex-col">
                                <blockquote class="text-gray-900 flex-grow">
                                    <p>“{{ $testimonial['text'] }}”</p>
                                </blockquote>
                                <figcaption class="mt-6 flex items-center gap-x-4 border-t border-gray-900/10 pt-6">
                                    <img class="h-12 w-12 flex-none rounded-full bg-white"
                                        src="https://i.pravatar.cc/48?img={{ $testimonial['img'] }}"
                                        alt="Foto Klien {{ $testimonial['name'] }}">
                                    <div>
                                        <div class="font-semibold">{{ $testimonial['name'] }}</div>
                                        <div class="text-gray-600">{{ $testimonial['title'] }}</div>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('horizontalSlider', () => ({
                isDown: false,
                startX: null,
                scrollLeft: null,

                init() {
                    const slider = this.$refs.slider;
                    if (!slider) return;

                    const start = (e) => {
                        this.isDown = true;
                        slider.classList.add('cursor-grabbing');
                        this.startX = (e.pageX || e.touches[0].pageX) - slider.offsetLeft;
                        this.scrollLeft = slider.scrollLeft;
                    };
                    const end = () => {
                        this.isDown = false;
                        slider.classList.remove('cursor-grabbing');
                    };
                    const move = (e) => {
                        if (!this.isDown) return;
                        e.preventDefault();
                        const x = (e.pageX || e.touches[0].pageX) - slider.offsetLeft;
                        const walk = (x - this.startX) * 2;
                        slider.scrollLeft = this.scrollLeft - walk;
                    };

                    slider.addEventListener('mousedown', start);
                    slider.addEventListener('touchstart', start, {
                        passive: true
                    });
                    slider.addEventListener('mouseleave', end);
                    slider.addEventListener('mouseup', end);
                    slider.addEventListener('touchend', end);
                    slider.addEventListener('mousemove', move);
                    slider.addEventListener('touchmove', move, {
                        passive: true
                    });
                },
                scroll(direction) {
                    const slider = this.$refs.slider;
                    const scrollAmount = slider.clientWidth * 0.8;
                    slider.scrollBy({
                        left: direction * scrollAmount,
                        behavior: 'smooth'
                    });
                },
                prev() {
                    this.scroll(-1);
                },
                next() {
                    this.scroll(1);
                }
            }));
        });
    </script>
@endpush
