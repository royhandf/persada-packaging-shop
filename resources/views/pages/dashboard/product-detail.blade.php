@extends('layouts.admin')

@section('title', 'Detail Produk')

@section('content')
    <div x-data="imagePreview()">
        <div class="flex flex-col items-start justify-between gap-4 mb-6 sm:flex-row sm:items-center">
            <div>
                <a href="{{ route('master.products.index') }}"
                    class="mb-2 inline-flex items-center text-sm font-medium text-gray-600 hover:text-persada-primary dark:text-gray-400 dark:hover:text-persada-accent">
                    <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" />
                    Kembali ke Manajemen Produk
                </a>
                <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $product->name }}
                    </h1>
                    <span
                        class="inline-flex items-center gap-x-1.5 px-2.5 py-1 text-xs font-medium rounded-full {{ $product->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                        @if ($product->status === 'active')
                            <x-heroicon-s-check class="w-2 h-2 fill-green-500" />
                        @else
                            <x-heroicon-s-x class="w-2 h-2 fill-gray-500" />
                        @endif
                        {{ ucfirst($product->status) }}
                    </span>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-50 p-4 dark:bg-red-900/30">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-x-circle class="h-5 w-5 text-red-400" />
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-300">Terdapat {{ $errors->count() }} error
                            pada input Anda:</h3>
                        <div class="mt-2 text-sm text-red-700 dark:text-red-400">
                            <ul role="list" class="list-disc space-y-1 pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="space-y-8">
            <div class="p-6 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Detail Produk</h2>
                <dl class="space-y-4">
                    <div class="flex items-start gap-12 sm:gap-16">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kategori</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                                {{ $product->category->name ?? '-' }}</dd>
                        </div>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Deskripsi</dt>
                        <dd class="mt-2 prose prose-sm max-w-none dark:prose-invert text-gray-600 dark:text-gray-300">
                            {!! $product->description !!}
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="p-6 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Gambar Produk</h2>
                <form action="{{ route('master.products.images.store', $product) }}" method="POST"
                    enctype="multipart/form-data" class="p-4 mb-6 border border-dashed rounded-lg dark:border-gray-600">
                    @csrf
                    <div class="flex flex-col items-center gap-4 sm:flex-row">
                        <div class="relative flex-1 w-full">
                            <label for="image-upload"
                                class="flex items-center justify-center w-full h-24 px-2 text-sm text-gray-500 border border-gray-300 rounded-md cursor-pointer dark:border-gray-500 dark:text-gray-400">
                                <template x-if="imagePreviewUrl">
                                    <img :src="imagePreviewUrl" class="object-contain h-full max-w-full rounded">
                                </template>
                                <div x-show="!imagePreviewUrl" class="text-center">
                                    <x-heroicon-o-photo class="w-8 h-8 mx-auto text-gray-400" />
                                    <span x-text="imageName ?? 'Pilih file gambar...'"></span>
                                </div>
                            </label>
                            <input type="file" name="image" id="image-upload" class="sr-only" x-ref="imageInput"
                                @change="previewImage()">
                        </div>
                        <div class="flex items-center self-stretch gap-4">
                            <label class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                                <input type="checkbox" name="is_primary" value="1"
                                    class="w-4 h-4 rounded text-persada-primary focus:ring-persada-primary/50 dark:bg-gray-700 dark:border-gray-600">
                                <span class="ml-2">Utama</span>
                            </label>
                            <button
                                class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white rounded-md bg-persada-primary hover:bg-persada-dark-hover">
                                <x-heroicon-o-arrow-up-tray class="w-4 h-4 sm:-ml-1 sm:mr-2" />
                                <span class="hidden sm:inline">Upload</span>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-5 lg:grid-cols-6">
                    @forelse ($product->images as $image)
                        <div class="relative group aspect-square">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gambar produk"
                                class="object-cover w-full h-full rounded-md shadow">
                            <div
                                class="absolute inset-0 flex items-center justify-center transition-opacity bg-black rounded-md opacity-0 bg-opacity-40 group-hover:opacity-100">
                                <form action="{{ route('master.products.images.destroy', [$product, $image]) }}"
                                    method="POST">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete(this.closest('form'))"
                                        class="p-2 text-white bg-red-600 rounded-full hover:bg-red-700">
                                        <x-heroicon-o-trash class="w-5 h-5" />
                                    </button>
                                </form>
                            </div>
                            @if ($image->is_primary)
                                <span
                                    class="absolute px-2 py-0.5 text-xs font-medium text-white bg-green-600 rounded-full top-2 left-2">Utama</span>
                            @endif
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400 col-span-full">Belum ada gambar produk.</p>
                    @endforelse
                </div>
            </div>

            <div class="p-6 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Varian Produk</h2>
                <form action="{{ route('master.products.variants.store', $product) }}" method="POST"
                    class="p-4 mb-6 border border-gray-200 rounded-lg dark:border-gray-700">
                    @csrf
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="variant-name"
                                class="block mb-1 text-xs font-medium text-gray-600 dark:text-gray-400">Nama Varian</label>
                            <input type="text" id="variant-name" name="name" placeholder="e.g., Merah, XL" required
                                class="block w-full text-sm border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-persada-primary focus:border-persada-primary">
                        </div>
                        <div>
                            <label for="variant-price"
                                class="block mb-1 text-xs font-medium text-gray-600 dark:text-gray-400">Harga</label>
                            <input type="number" id="variant-price" name="price" placeholder="Rp 150000" required
                                class="block w-full text-sm border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-persada-primary focus:border-persada-primary">
                        </div>
                        <div>
                            <label for="variant-stock"
                                class="block mb-1 text-xs font-medium text-gray-600 dark:text-gray-400">Stok</label>
                            <input type="number" id="variant-stock" name="stock" placeholder="100" required
                                class="block w-full text-sm border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-persada-primary focus:border-persada-primary">
                        </div>
                        <div>
                            <label for="variant-sku"
                                class="block mb-1 text-xs font-medium text-gray-600 dark:text-gray-400">SKU
                                (Opsional)</label>
                            <input type="text" id="variant-sku" name="sku" placeholder="SKU-MERAH-XL"
                                class="block w-full text-sm border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-persada-primary focus:border-persada-primary">
                        </div>
                        <div>
                            <label for="variant-moq"
                                class="block mb-1 text-xs font-medium text-gray-600 dark:text-gray-400">MOQ</label>
                            <input type="number" id="variant-moq" name="moq" value="1" required
                                class="block w-full text-sm border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-persada-primary focus:border-persada-primary">
                        </div>
                        <div class="sm:col-span-2">
                            <label for="variant-weight"
                                class="block mb-1 text-xs font-medium text-gray-600 dark:text-gray-400">Berat
                                (gram)</label>
                            <input type="number" id="variant-weight" name="weight_in_grams" placeholder="e.g., 250"
                                class="block w-full text-sm border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-persada-primary focus:border-persada-primary">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block mb-1 text-xs font-medium text-gray-600 dark:text-gray-400">Dimensi P x L x
                                T (cm)</label>
                            <div class="flex gap-2">
                                <input type="number" name="length_in_cm" placeholder="P"
                                    class="block w-full text-sm border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-persada-primary focus:border-persada-primary">
                                <input type="number" name="width_in_cm" placeholder="L"
                                    class="block w-full text-sm border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-persada-primary focus:border-persada-primary">
                                <input type="number" name="height_in_cm" placeholder="T"
                                    class="block w-full text-sm border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-persada-primary focus:border-persada-primary">
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <button
                                class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-semibold text-white rounded-md bg-persada-primary hover:bg-persada-dark-hover">
                                <x-heroicon-o-plus class="w-4 h-4 -ml-1 mr-2" />
                                Tambah Varian
                            </button>
                        </div>
                    </div>
                </form>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-300">
                                    Nama Varian</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-300">
                                    SKU</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-300">
                                    Harga</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-300">
                                    Stok</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-300">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ($product->variants as $variant)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $variant->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $variant->sku ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                        Rp {{ number_format($variant->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $variant->stock }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <div class="flex items-center gap-x-2">
                                            <form
                                                action="{{ route('master.products.variants.destroy', [$product, $variant]) }}"
                                                method="POST">
                                                @csrf @method('DELETE')
                                                <button type="button" onclick="confirmDelete(this.closest('form'))"
                                                    title="Hapus Varian"
                                                    class="p-1.5 rounded bg-red-600 text-white hover:bg-red-700">
                                                    <x-heroicon-o-trash class="w-4 h-4" />
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5"
                                        class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                        Belum ada varian produk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function imagePreview() {
            return {
                imageName: null,
                imagePreviewUrl: null,

                previewImage() {
                    const file = this.$refs.imageInput.files[0];
                    if (file) {
                        this.imageName = file.name;
                        this.imagePreviewUrl = URL.createObjectURL(file);
                    } else {
                        this.imageName = null;
                        this.imagePreviewUrl = null;
                    }
                }
            }
        }
    </script>
@endpush
