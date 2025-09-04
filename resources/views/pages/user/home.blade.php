@extends('layouts.app')

@section('title', 'Home - Persada Packaging')

@section('content')
    <section class="h-screen bg-cover bg-center" style="background-image: url('{{ asset('images/hero-background.jpg') }}')">
        {{-- Dibiarkan kosong untuk tampilan minimalis sesuai desain --}}
    </section>

    @php
        $products = [
            [
                'id' => 1,
                'name' => 'Botol lipgloss bul...',
                'price' => 9150,
                'image' => asset('images/product.jpg'),
            ],
            [
                'id' => 2,
                'name' => 'Botol Aireless Pin...',
                'price' => 16300,
                'image' => asset('images/product.jpg'),
            ],
            [
                'id' => 3,
                'name' => 'Pot cream kaca ...',
                'price' => 14000,
                'image' => asset('images/product.jpg'),
            ],
            [
                'id' => 4,
                'name' => 'Botol lipmatte lip...',
                'price' => 7600,
                'image' => asset('images/product.jpg'),
            ],
            [
                'id' => 5,
                'name' => 'Tisu pembersih b...',
                'price' => 17100,
                'image' => asset('images/product.jpg'),
            ],
            [
                'id' => 6,
                'name' => 'wadah cushion l...',
                'price' => 15900,
                'image' => asset('images/product.jpg'),
            ],
            [
                'id' => 7,
                'name' => 'Botol aireless pu...',
                'price' => 13100,
                'image' => asset('images/product.jpg'),
            ],
            [
                'id' => 8,
                'name' => 'Pot Cream 50g k...',
                'price' => 10600,
                'image' => asset('images/product.jpg'),
            ],
        ];
    @endphp
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <h2 class="text-3xl font-display font-semibold text-center text-persada-dark mb-12">Our Products</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($products as $product)
                <a href="#" class="group">
                    <div
                        class="bg-white border border-gray-200 rounded-lg p-4 text-center transform hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}"
                            class="w-full h-48 object-contain mx-auto">
                        <h3 class="mt-4 font-semibold text-persada-dark truncate" title="{{ $product['name'] }}">
                            {{ $product['name'] }}</h3>
                        <div class="flex justify-between items-center mt-2">
                            <p class="text-persada-primary font-bold">
                                Rp {{ number_format($product['price'], 0, ',', '.') }}/pcs
                            </p>
                            <button
                                class="bg-persada-primary/10 text-persada-primary h-9 w-9 rounded-full flex items-center justify-center hover:bg-persada-primary hover:text-white transition">
                                <x-heroicon-o-shopping-bag class="h-5 w-5" />
                            </button>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

@endsection
