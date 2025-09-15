@extends('layouts.app')

@section('title', 'Tentang Kami - Persada Packaging')

@section('content')
    <section class="relative bg-persada-dark h-80 flex items-center justify-center">
        <div class="absolute inset-0 z-0 opacity-20">
            <img class="object-cover w-full h-full" src="{{ asset('images/skincare-shades.jpg') }}"
                alt="Tim Persada Packaging sedang berdiskusi">
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full z-10 text-center text-white" x-data="{ show: false }"
            x-init="setTimeout(() => show = true, 300)">
            <h1 class="text-4xl sm:text-5xl font-display font-bold" x-show="show"
                x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 translate-y-8"
                x-transition:enter-end="opacity-100 translate-y-0">
                Tentang Persada Packaging
            </h1>
        </div>
    </section>

    <section class="bg-white py-20 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                <div class="text-left" x-data x-intersect:enter.once="$el.classList.add('animate-fade-in-right')">
                    <h2 class="text-base font-semibold text-persada-primary tracking-wider uppercase">Visi & Misi Kami</h2>
                    <p class="mt-2 text-3xl font-display font-bold text-persada-dark tracking-tight sm:text-4xl">
                        Membentuk Cerita Merek Melalui Kemasan Premium
                    </p>
                    <p class="mt-6 text-lg text-gray-600">
                        <strong>Persada Packaging</strong> lahir dari sebuah keyakinan sederhana: kemasan adalah duta
                        pertama sebuah merek.
                        Berawal dari visi untuk mendefinisikan ulang keanggunan dalam industri kemasan kosmetik, kami
                        bertransformasi
                        dari sekadar pemasok menjadi partner strategis bagi puluhan merek ternama.
                    </p>
                    <p class="mt-4 text-lg text-gray-600">
                        Misi kami adalah memberdayakan setiap merek untuk menceritakan kisahnya yang unik melalui desain
                        yang fungsional,
                        material yang berkelanjutan, dan kualitas yang tak tertandingi.
                    </p>
                </div>
                <div class="mt-12 lg:mt-0" x-data x-intersect:enter.once="$el.classList.add('animate-fade-in-left')">
                    <div class="rounded-2xl overflow-hidden shadow-xl aspect-[4/3]">
                        <img src="{{ asset('images/product.jpg') }}" alt="Kemasan Kosmetik Premium"
                            class="object-cover w-full h-full" />
                    </div>
                </div>


            </div>
        </div>
    </section>

    <section class="bg-gray-50 py-20 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base font-semibold text-persada-primary tracking-wider uppercase">Nilai Kami</h2>
                <p class="mt-2 text-3xl font-display font-bold text-persada-dark tracking-tight sm:text-4xl">
                    Tiga Pilar Utama Kami
                </p>
            </div>
            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
                <div>
                    <div
                        class="mx-auto h-16 w-16 rounded-full bg-persada-primary/10 flex items-center justify-center text-persada-primary">
                        <x-heroicon-o-sparkles class="h-8 w-8" />
                    </div>
                    <h3 class="mt-6 text-xl font-semibold text-persada-dark">Inovasi Berkesadaran</h3>
                    <p class="mt-2 text-gray-600">
                        Kami terus mengikuti tren global, fungsionalitas, dan estetika untuk menciptakan kemasan yang
                        relevan,
                        menarik, dan menjawab kebutuhan pasar.
                    </p>
                </div>
                <div>
                    <div
                        class="mx-auto h-16 w-16 rounded-full bg-persada-primary/10 flex items-center justify-center text-persada-primary">
                        <x-heroicon-o-globe-alt class="h-8 w-8" />
                    </div>
                    <h3 class="mt-6 text-xl font-semibold text-persada-dark">Bahan Baku Berkelanjutan</h3>
                    <p class="mt-2 text-gray-600">
                        Kami berkomitmen menyediakan pilihan material ramah lingkungan untuk membantu Anda membangun merek
                        yang tidak hanya indah, tapi juga bertanggung jawab.
                    </p>
                </div>

                <div>
                    <div
                        class="mx-auto h-16 w-16 rounded-full bg-persada-primary/10 flex items-center justify-center text-persada-primary">
                        <x-heroicon-o-users class="h-8 w-8" />
                    </div>
                    <h3 class="mt-6 text-xl font-semibold text-persada-dark">Kemitraan Kolaboratif</h3>
                    <p class="mt-2 text-gray-600">
                        Kami adalah perpanjangan tangan dari tim Anda. Kami berkolaborasi di setiap langkah untuk memastikan
                        visi Anda terwujud dengan sempurna.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="max-w-4xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-display font-bold text-persada-dark sm:text-4xl">
                Siap Mewujudkan Visi Anda?
            </h2>
            <p class="mt-4 text-lg leading-6 text-gray-600">
                Hubungi kami hari ini untuk konsultasi dan temukan bagaimana kemasan yang tepat dapat memajukan merek Anda
                ke level berikutnya.
            </p>
            <a href="whatsapp://send?phone=6281283635368&text=Halo%2C%20Saya%20tertarik%20dengan%20produk%20Anda."
                target="_blank"
                class="mt-8 w-full inline-flex items-center justify-center
   px-5 py-3 border border-transparent text-base font-medium rounded-full text-white bg-persada-primary
   hover:bg-persada-primary/90 sm:w-auto transition-colors">
                Hubungi Kami
            </a>
        </div>
    </section>

@endsection
