@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="bg-white pt-32 pb-24" x-data="productDetailManager(
        '{{ $product->primaryImage ? asset('storage/' . $product->primaryImage->image_path) : asset('images/default-product.png') }}',
        {{ $product->variants->first() ? json_encode($product->variants->first()) : 'null' }}
    )">
        <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-breadcrumb :items="[
                ['text' => 'Beranda', 'url' => route('home')],
                ['text' => 'Produk', 'url' => route('products.index')],
                ['text' => $product->name],
            ]" />

            <section class="grid grid-cols-1 lg:grid-cols-7 gap-x-12">
                <div class="lg:col-span-3">
                    <div class="flex flex-col gap-4 sticky top-28">
                        <div class="aspect-square w-full overflow-hidden rounded-xl shadow-lg bg-white">
                            <img :src="mainImage" alt="{{ $product->name }}"
                                class="h-full w-full object-cover object-center transition-opacity duration-300"
                                x-ref="mainImageRef">
                        </div>
                        @if ($product->images->count() > 1)
                            <div class="grid grid-cols-5 gap-4">
                                @foreach ($product->images as $image)
                                    <button type="button"
                                        @click="changeMainImage('{{ asset('storage/' . $image->image_path) }}')"
                                        class="aspect-square cursor-pointer overflow-hidden rounded-md transition-all duration-200 focus:outline-none"
                                        :class="{ 'ring-2 ring-persada-primary ring-offset-2 scale-105': mainImage === '{{ asset('storage/' . $image->image_path) }}' }">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Thumbnail"
                                            class="h-full w-full object-cover object-center">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-4 mt-8 lg:mt-0">
                    <h1 class="text-3xl lg:text-4xl font-bold font-display text-gray-900">{{ $product->name }}</h1>
                    <p class="mt-4 text-3xl tracking-tight text-persada-primary font-sans font-bold">
                        <span x-text="formattedPrice"></span>
                    </p>
                    <hr class="my-6 border-gray-200">

                    <form action="{{ route('cart.store') }}" method="POST" class="space-y-8">
                        @csrf
                        <input type="hidden" name="product_variant_id" :value="selectedVariant ? selectedVariant.id : ''">
                        <input type="hidden" name="quantity" :value="quantity">

                        @if ($product->variants->count() > 0)
                            <div class="grid grid-cols-1 gap-y-3">
                                <label class="text-base font-semibold text-gray-900">Pilih Varian:</label>
                                <div class="flex flex-wrap gap-3">
                                    @foreach ($product->variants as $variant)
                                        <div class="relative">
                                            <button type="button" @click="selectVariant({{ json_encode($variant) }})"
                                                :disabled="{{ $variant->stock }} === 0"
                                                :class="{
                                                    'border-persada-primary text-persada-primary': selectedVariant &&
                                                        selectedVariant.id === '{{ $variant->id }}',
                                                    'border-gray-300 text-gray-800 hover:border-gray-400': !
                                                        selectedVariant || selectedVariant
                                                        .id !== '{{ $variant->id }}',
                                                    'opacity-50 cursor-not-allowed': {{ $variant->stock }} === 0
                                                }"
                                                class="relative flex min-w-[5rem] items-center justify-center rounded-md border bg-white px-4 py-2 text-sm font-medium transition duration-150 focus:outline-none">
                                                <span
                                                    :class="{ 'line-through': {{ $variant->stock }} === 0 }">{{ $variant->name }}</span>
                                            </button>
                                            <div x-show="selectedVariant && selectedVariant.id === '{{ $variant->id }}'"
                                                x-transition
                                                class="pointer-events-none absolute -bottom-1.5 -right-1.5 h-6 w-6">
                                                <x-heroicon-s-check-circle class="h-6 w-6 text-persada-primary" />
                                                <div class="absolute inset-0 -z-10 bg-white"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div>
                            <h3 class="text-base font-medium text-gray-900">Kuantitas</h3>
                            <div class="mt-3 flex items-center">
                                <div class="flex items-center border border-gray-300 rounded-lg">
                                    <button type="button" @click="decrement()"
                                        :disabled="!selectedVariant || quantity <= selectedVariant.moq"
                                        class="px-3 py-2 text-gray-500 disabled:opacity-50 disabled:cursor-not-allowed transition">-</button>
                                    <input type="text" x-model.number="quantity" @change="validateQuantity()"
                                        class="w-16 border-t-0 border-b-0 border-x text-center focus:ring-0 focus:border-gray-300">
                                    <button type="button" @click="increment()"
                                        :disabled="!selectedVariant || quantity >= selectedVariant.stock"
                                        class="px-3 py-2 text-gray-500 disabled:opacity-50 disabled:cursor-not-allowed transition">+</button>
                                </div>
                                <div class="ml-4 text-sm text-gray-500" x-show="selectedVariant">
                                    <p>Stok: <span x-text="selectedVariant.stock"></span></p>
                                    <p>Min. Beli: <span x-text="selectedVariant.moq"></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-4 pt-4">
                            <button type="submit" :disabled="!selectedVariant"
                                class="w-full flex-1 flex items-center justify-center rounded-lg border border-persada-primary bg-persada-primary/10 py-3 px-8 text-base font-medium text-persada-primary hover:bg-persada-primary/20 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                <x-heroicon-o-shopping-cart class="h-5 w-5 mr-2" />
                                <span>Masukkan Keranjang</span>
                            </button>
                            <a href="#"
                                class="flex-1 w-full flex items-center justify-center rounded-lg border border-transparent bg-persada-primary py-3 px-8 text-base font-medium text-white shadow-sm hover:bg-persada-dark transition-colors"
                                :class="{ 'opacity-50 cursor-not-allowed': !selectedVariant }"
                                @click.prevent="if (!selectedVariant) return;">
                                Beli Sekarang
                            </a>
                        </div>
                    </form>
                </div>
            </section>

            <section class="mt-16">
                <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200/80">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                            <button @click="activeTab = 'description'"
                                :class="{ 'border-persada-primary text-persada-dark': activeTab === 'description', 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': activeTab !== 'description' }"
                                class="whitespace-nowrap border-b-2 py-4 px-1 text-base font-medium transition-colors focus:outline-none">
                                Deskripsi
                            </button>
                            <button @click="activeTab = 'specs'"
                                :class="{ 'border-persada-primary text-persada-dark': activeTab === 'specs', 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': activeTab !== 'specs' }"
                                class="whitespace-nowrap border-b-2 py-4 px-1 text-base font-medium transition-colors focus:outline-none">
                                Spesifikasi
                            </button>
                        </nav>
                    </div>
                    <div class="pt-8">
                        <div x-show="activeTab === 'description'" class="prose prose-slate max-w-none">
                            {!! $product->description !!}
                        </div>
                        <div x-show="activeTab === 'specs'" style="display: none;">
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                                <div class="border-t border-gray-200 pt-4">
                                    <dt class="font-medium text-gray-900">Kategori</dt>
                                    <dd class="mt-1 text-gray-500">{{ $product->category->name }}</dd>
                                </div>
                                <div x-show="selectedVariant" class="border-t border-gray-200 pt-4">
                                    <dt class="font-medium text-gray-900">SKU Varian</dt>
                                    <dd class="mt-1 text-gray-500" x-text="selectedVariant.sku || '-'"></dd>
                                </div>
                                <div x-show="selectedVariant" class="border-t border-gray-200 pt-4">
                                    <dt class="font-medium text-gray-900">Minimum Order (MOQ)</dt>
                                    <dd class="mt-1 text-gray-500" x-text="`${selectedVariant.moq} Pcs`"></dd>
                                </div>
                                <div x-show="selectedVariant" class="border-t border-gray-200 pt-4">
                                    <dt class="font-medium text-gray-900">Berat</dt>
                                    <dd class="mt-1 text-gray-500" x-text="`${selectedVariant.weight_in_grams} gram`">
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </section>

            @if ($relatedProducts->isNotEmpty())
                <section class="mt-16">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold font-display tracking-tight text-gray-900">Produk Sejenis Lainnya
                        </h2>
                        <a href="{{ route('products.index', ['categories[]' => $product->category->id]) }}"
                            class="text-sm font-medium text-persada-primary hover:text-persada-dark transition-colors">
                            Lihat Semua &rarr;
                        </a>
                    </div>
                    <div class="mt-8 grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-6">
                        @foreach ($relatedProducts as $relatedProduct)
                            <x-product-card :product="$relatedProduct" />
                        @endforeach
                    </div>
                </section>
            @endif
        </main>
    </div>
@endsection

@push('scripts')
    <script>
        function productDetailManager(initialImage, initialVariant) {
            return {
                mainImage: initialImage,
                selectedVariant: initialVariant,
                quantity: initialVariant ? initialVariant.moq : 1,
                activeTab: 'description',

                get formattedPrice() {
                    if (!this.selectedVariant) {
                        return 'Pilih varian untuk melihat harga';
                    }
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(this.selectedVariant.price);
                },

                init() {
                    this.$watch('selectedVariant', (newVariant) => this.handleVariantChange(newVariant));
                },
                increment() {
                    if (this.selectedVariant && this.quantity < this.selectedVariant.stock) {
                        this.quantity++;
                    }
                },
                decrement() {
                    if (this.selectedVariant && this.quantity > this.selectedVariant.moq) {
                        this.quantity--;
                    }
                },
                handleVariantChange(variant) {
                    if (!variant) return;

                    if (this.quantity < variant.moq) this.quantity = variant.moq;
                    if (this.quantity > variant.stock) this.quantity = variant.stock;
                },
                validateQuantity() {
                    if (!this.selectedVariant) return;
                    const value = parseInt(this.quantity) || this.selectedVariant
                        .moq;
                    if (value < this.selectedVariant.moq) this.quantity = this.selectedVariant.moq;
                    else if (value > this.selectedVariant.stock) this.quantity = this.selectedVariant.stock;
                    else this.quantity = value;
                },
                selectVariant(variant) {
                    this.selectedVariant = variant;
                },
                changeMainImage(newImageUrl) {
                    this.$refs.mainImageRef.style.opacity = 0;
                    setTimeout(() => {
                        this.mainImage = newImageUrl;
                        this.$refs.mainImageRef.style.opacity = 1;
                    }, 200);
                }
            }
        }
    </script>
@endpush
