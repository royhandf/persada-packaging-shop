@props(['product'])

<div
    class="group relative overflow-hidden rounded-lg bg-white shadow-sm transition-all duration-300 hover:shadow-lg border border-gray-200/80">
    <a href="{{ route('products.detail', $product) }}">
        <div class="aspect-square overflow-hidden">
            <img src="{{ $product->primaryImage ? asset('storage/' . $product->primaryImage->image_path) : 'https://via.placeholder.com/400' }}"
                alt="{{ $product->name }}" loading="lazy" decoding="async"
                class="h-full w-full object-cover object-center transition-transform duration-300 group-hover:scale-105">
        </div>
        <div class="p-4">
            <h3 class="text-base font-semibold text-gray-800 truncate">{{ $product->name }}</h3>
            <p class="mt-2 text-lg font-bold text-persada-primary">
                @if ($product->lowestPriceVariant)
                    Rp{{ number_format($product->lowestPriceVariant->price, 0, ',', '.') }}
                @else
                    <span class="text-sm font-normal text-gray-500">Harga tidak tersedia</span>
                @endif
            </p>
        </div>
        <div
            class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
            <span
                class="flex items-center gap-x-2 rounded-full bg-persada-primary px-5 py-2.5 text-sm font-semibold text-white">
                <x-heroicon-o-eye class="h-5 w-5" />
                Lihat Detail
            </span>
        </div>
    </a>
</div>
