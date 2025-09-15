@extends('layouts.app')

@section('title', 'Jelajahi Produk Kami')

@section('content')
    <div class="bg-slate-50 pt-24" x-data="{ filtersOpen: false }">
        <div x-show="filtersOpen" class="relative z-50 lg:hidden" x-ref="dialog" aria-modal="true" style="display: none;">
            <div x-show="filtersOpen" x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black bg-opacity-25"></div>
            <div class="fixed inset-0 z-40 flex">
                <div x-show="filtersOpen" x-transition:enter="transition ease-in-out duration-300 transform"
                    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in-out duration-300 transform"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                    @click.away="filtersOpen = false"
                    class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-12 shadow-xl">
                    <div class="flex items-center justify-between px-4">
                        <h2 class="text-lg font-medium text-gray-900">Filter</h2>
                        <button @click="filtersOpen = false" type="button"
                            class="-mr-2 flex h-10 w-10 items-center justify-center rounded-md bg-white p-2 text-gray-400">
                            <span class="sr-only">Close menu</span>
                            <x-heroicon-o-x-mark class="h-6 w-6" />
                        </button>
                    </div>
                    <div class="mt-4 border-t border-gray-200 px-4">
                        <form id="filter-form-mobile" action="{{ route('products.index') }}" method="GET">
                            <div class="space-y-8 divide-y divide-gray-200">
                                <div class="pt-6">
                                    <h3 class="text-lg font-semibold text-persada-dark mb-3">Kategori</h3>
                                    <div class="space-y-3">
                                        @foreach ($categories as $category)
                                            <div class="flex items-center">
                                                <input id="cat-mobile-{{ $category->id }}" name="categories[]"
                                                    value="{{ $category->id }}" type="checkbox"
                                                    {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}
                                                    class="h-4 w-4 rounded border-gray-300 text-persada-primary focus:ring-persada-primary/50">
                                                <label for="cat-mobile-{{ $category->id }}"
                                                    class="ml-3 text-sm text-gray-600">{{ $category->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="pt-6">
                                    <h3 class="text-lg font-semibold text-persada-dark mb-3">Rentang Harga</h3>
                                    <div id="price-slider-mobile" class="my-4"></div>
                                    <div class="mt-4 flex justify-between items-center text-sm text-gray-600">
                                        <span>Rp <span
                                                id="min-price-label-mobile">{{ number_format(request('min_price', $priceBounds['min']), 0, ',', '.') }}</span></span>
                                        <span>Rp <span
                                                id="max-price-label-mobile">{{ number_format(request('max_price', $priceBounds['max']), 0, ',', '.') }}</span></span>
                                    </div>
                                    <input type="hidden" id="min_price_mobile" name="min_price"
                                        value="{{ request('min_price', $priceBounds['min']) }}">
                                    <input type="hidden" id="max_price_mobile" name="max_price"
                                        value="{{ request('max_price', $priceBounds['max']) }}">
                                </div>
                                <div class="pt-6">
                                    <button type="submit"
                                        class="w-full bg-persada-primary text-white font-semibold py-2.5 px-4 rounded-lg hover:bg-persada-dark transition-colors duration-300">Terapkan
                                        Filter</button>
                                    <a href="{{ route('products.index') }}"
                                        class="mt-2 block w-full text-center text-sm text-gray-600 hover:text-persada-primary">Reset
                                        Filter</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="border-b border-gray-200 bg-slate-50 pt-12 pb-8">
                <h1 class="text-4xl font-bold font-display tracking-tight text-persada-dark">Semua Produk</h1>
                <p class="mt-4 max-w-2xl text-gray-600">Temukan solusi kemasan terbaik yang dirancang khusus untuk
                    meningkatkan nilai dan estetika produk kecantikan Anda.</p>
            </div>

            <section class="pt-8 pb-24">
                <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
                    <aside class="hidden lg:block lg:col-span-1">
                        <div class="sticky top-32">
                            <form id="filter-form-desktop" action="{{ route('products.index') }}" method="GET">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                                <div class="space-y-8 divide-y divide-gray-200">
                                    <div class="pt-2">
                                        <h3 class="text-lg font-semibold text-persada-dark mb-3">Kategori</h3>
                                        <div class="space-y-3">
                                            @foreach ($categories as $category)
                                                <div class="flex items-center">
                                                    <input id="cat-desktop-{{ $category->id }}" name="categories[]"
                                                        value="{{ $category->id }}" type="checkbox"
                                                        {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}
                                                        class="h-4 w-4 rounded border-gray-300 text-persada-primary focus:ring-persada-primary/50">
                                                    <label for="cat-desktop-{{ $category->id }}"
                                                        class="ml-3 text-sm text-gray-600">{{ $category->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="pt-6">
                                        <h3 class="text-lg font-semibold text-persada-dark mb-3">Rentang Harga</h3>
                                        <div id="price-slider-desktop" class="my-4"></div>
                                        <div class="mt-4 flex justify-between items-center text-sm text-gray-600">
                                            <span>Rp <span
                                                    id="min-price-label-desktop">{{ number_format(request('min_price', $priceBounds['min']), 0, ',', '.') }}</span></span>
                                            <span>Rp <span
                                                    id="max-price-label-desktop">{{ number_format(request('max_price', $priceBounds['max']), 0, ',', '.') }}</span></span>
                                        </div>
                                        <input type="hidden" id="min_price_desktop" name="min_price"
                                            value="{{ request('min_price', $priceBounds['min']) }}">
                                        <input type="hidden" id="max_price_desktop" name="max_price"
                                            value="{{ request('max_price', $priceBounds['max']) }}">
                                    </div>
                                    <div class="pt-6">
                                        <button type="submit"
                                            class="w-full bg-persada-primary text-white font-semibold py-2.5 px-4 rounded-lg hover:bg-persada-dark transition-colors duration-300">Terapkan</button>
                                        <a href="{{ route('products.index') }}"
                                            class="mt-2 block w-full text-center text-sm text-gray-600 hover:text-persada-primary">Reset
                                            Filter</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </aside>

                    <div class="lg:col-span-3">
                        <div class="rounded-lg border border-gray-200 bg-slate-100 px-4 py-3 mb-8">
                            <div class="space-y-4 lg:space-y-0 lg:flex lg:items-center lg:justify-between">
                                <div class="w-full lg:w-auto text-center sm:text-left">
                                    <p class="text-sm text-gray-600">
                                        Menampilkan <span
                                            class="font-semibold text-persada-dark">{{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}</span>
                                        dari <span class="font-semibold text-persada-dark">{{ $products->total() }}</span>
                                        hasil
                                    </p>
                                </div>

                                <form id="control-form" action="{{ route('products.index') }}" method="GET"
                                    class="flex flex-col sm:flex-row items-center gap-4 w-full lg:w-auto">

                                    @foreach (request('categories', []) as $cat)
                                        <input type="hidden" name="categories[]" value="{{ $cat }}">
                                    @endforeach
                                    <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                                    <input type="hidden" name="max_price" value="{{ request('max_price') }}">

                                    <div class="relative w-full sm:flex-grow">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                            <x-heroicon-o-magnifying-glass class="h-5 w-5 text-gray-400" />
                                        </span>
                                        <input type="search" name="search" placeholder="Cari produk..."
                                            value="{{ request('search') }}"
                                            class="w-full rounded-md border-gray-300 py-1.5 pl-10 text-sm focus:border-persada-primary focus:ring-persada-primary">
                                    </div>

                                    <div class="flex items-center justify-between w-full sm:w-auto gap-4">
                                        <button type="button" @click="filtersOpen = true"
                                            class="lg:hidden inline-flex items-center gap-x-2 rounded-md bg-white px-3 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 flex-grow justify-center">
                                            <x-heroicon-o-funnel class="h-5 w-5 text-gray-400" />
                                            Filter
                                        </button>

                                        <select name="sort" onchange="this.form.submit()"
                                            class="rounded-md border-gray-300 py-1.5 text-sm focus:border-persada-primary focus:ring-persada-primary flex-grow">
                                            <option value="" disabled @selected(!request('sort'))>Urutkan</option>
                                            <option value="price_asc" @selected(request('sort') == 'price_asc')>Harga Terendah</option>
                                            <option value="price_desc" @selected(request('sort') == 'price_desc')>Harga Tertinggi
                                            </option>
                                        </select>
                                    </div>

                                </form>
                            </div>
                        </div>

                        @if ($products->count() > 0)
                            <div class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-6">
                                @foreach ($products as $product)
                                    <x-product-card :product="$product" />
                                @endforeach
                            </div>
                            <div class="mt-12">
                                {{ $products->appends(request()->query())->links() }}
                            </div>
                        @else
                            <div class="text-center py-20 bg-gray-50 rounded-lg border">
                                <x-heroicon-o-x-circle class="mx-auto h-12 w-12 text-gray-400" />
                                <h3 class="mt-2 text-xl font-semibold text-persada-dark">Produk Tidak Ditemukan</h3>
                                <p class="mt-1 text-sm text-gray-500">Coba ubah kata kunci pencarian atau filter Anda.</p>
                                <a href="{{ route('products.index') }}"
                                    class="mt-6 inline-block bg-persada-primary text-white font-semibold py-2 px-5 rounded-full text-sm hover:bg-persada-dark transition-colors duration-300">Reset
                                    Filter</a>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        </main>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const configs = [{
                    el: "price-slider-desktop",
                    minLabel: "min-price-label-desktop",
                    maxLabel: "max-price-label-desktop",
                    minInput: "min_price_desktop",
                    maxInput: "max_price_desktop",
                },
                {
                    el: "price-slider-mobile",
                    minLabel: "min-price-label-mobile",
                    maxLabel: "max-price-label-mobile",
                    minInput: "min_price_mobile",
                    maxInput: "max_price_mobile",
                }
            ];

            configs.forEach(cfg => {
                const el = document.getElementById(cfg.el);
                if (!el) return;

                const minLabel = document.getElementById(cfg.minLabel);
                const maxLabel = document.getElementById(cfg.maxLabel);
                const minInput = document.getElementById(cfg.minInput);
                const maxInput = document.getElementById(cfg.maxInput);

                window.rangeSlider(el, {
                    min: {{ $priceBounds['min'] }},
                    max: {{ $priceBounds['max'] }},
                    value: [parseInt(minInput.value), parseInt(maxInput.value)],
                    onInput: (value) => {
                        const [min, max] = value;
                        minLabel.textContent = new Intl.NumberFormat("id-ID").format(min);
                        maxLabel.textContent = new Intl.NumberFormat("id-ID").format(max);
                        minInput.value = min;
                        maxInput.value = max;
                    },
                });
            });
        });
    </script>
@endpush
