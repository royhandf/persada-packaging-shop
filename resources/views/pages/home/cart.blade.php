@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
    <div class="bg-gray-50 pt-36 pb-32" x-data="cartManager({{ json_encode($cartItems) }})">
        <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="border-b border-gray-200 pb-5">
                <h1 class="text-3xl font-bold font-display tracking-tight text-gray-900 sm:text-4xl">
                    Keranjang Belanja
                </h1>
                <p class="mt-4 max-w-3xl text-base text-gray-500">
                    Periksa kembali detail produk di keranjang Anda sebelum melanjutkan ke proses checkout.
                </p>
            </div>

            <div class="mt-10">
                @if ($cartItems->isEmpty())
                    <div class="text-center py-16 px-6 bg-white rounded-2xl shadow-sm">
                        <x-heroicon-o-shopping-bag class="mx-auto h-16 w-16 text-gray-300" />
                        <h3 class="mt-4 text-xl font-semibold text-gray-800">Keranjang Anda Kosong</h3>
                        <p class="mt-2 text-gray-500">Ayo jelajahi produk kemasan terbaik untuk brand Anda.</p>
                        <a href="{{ route('products.index') }}"
                            class="mt-6 inline-block bg-persada-primary text-white font-medium py-3 px-6 rounded-lg shadow hover:bg-persada-dark transition">
                            Jelajahi Produk
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">
                        <div class="xl:col-span-2 space-y-6">
                            <div class="flex items-center justify-between bg-white px-5 py-4 rounded-xl shadow-sm">
                                <div class="flex items-center">
                                    <input type="checkbox" id="select-all" x-model="selectAll" @change="toggleSelectAll()"
                                        class="h-5 w-5 rounded border-gray-300 text-persada-primary focus:ring-persada-primary/50">
                                    <label for="select-all" class="ml-3 text-sm font-medium text-gray-700">Pilih
                                        Semua</label>
                                </div>
                                <button type="button" @click="deleteSelected" :disabled="selectedItems.length === 0"
                                    class="flex items-center gap-x-1 text-sm font-medium text-red-500 hover:text-red-700 disabled:text-gray-400 disabled:cursor-not-allowed">
                                    <x-heroicon-o-trash class="h-4 w-4" /> Hapus
                                </button>
                            </div>

                            <ul role="list" class="space-y-4">
                                <template x-for="item in items" :key="item.id">
                                    <li class="bg-white rounded-xl shadow-sm p-5 flex flex-col sm:flex-row gap-5">
                                        <input type="checkbox" x-model="item.selected" @change="updateSelection()"
                                            class="h-5 w-5 rounded border-gray-300 text-persada-primary focus:ring-persada-primary/50 flex-shrink-0 sm:mt-10">

                                        <img :src="item.product_variant.product.primary_image ?
                                            '{{ asset('storage') }}/' + item.product_variant.product.primary_image
                                            .image_path :
                                            '{{ asset('images/default-product.png') }}'"
                                            :alt="item.product_variant.product.name"
                                            class="h-28 w-28 rounded-lg object-cover flex-shrink-0">

                                        <div class="flex-1 flex flex-col justify-between">
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-800">
                                                    <a :href="`{{ route('products.detail', ':id') }}`.replace(':id', item
                                                        .product_variant.product.id)"
                                                        x-text="item.product_variant.product.name">
                                                    </a>
                                                </h3>

                                                <p class="mt-1 text-sm text-gray-500" x-text="item.product_variant.name">
                                                </p>
                                                <p class="mt-2 text-base font-bold text-persada-primary"
                                                    x-text="`Rp${new Intl.NumberFormat('id-ID').format(item.product_variant.price)}`">
                                                </p>
                                            </div>

                                            <div class="mt-4 flex items-center justify-between">
                                                <div class="flex items-center rounded-lg border border-gray-200 overflow-hidden"
                                                    :class="{ 'ring-2 ring-persada-primary/50': item.saving }">
                                                    <button type="button"
                                                        @click="item.quantity > item.product_variant.moq ? (item.quantity--, updateQuantity(item)) : null"
                                                        class="px-3 py-1 text-gray-600 hover:bg-gray-50 disabled:opacity-50"
                                                        :disabled="item.quantity <= item.product_variant.moq">-</button>
                                                    <input type="number" :name="`quantity_${item.id}`"
                                                        x-model.number="item.quantity"
                                                        @input.debounce.1000ms="updateQuantity(item)"
                                                        :min="item.product_variant.moq" :max="item.product_variant.stock"
                                                        class="w-16 text-center border-x border-gray-200 focus:ring-0 focus:border-gray-200 py-1">
                                                    <button type="button"
                                                        @click="item.quantity < item.product_variant.stock ? (item.quantity++, updateQuantity(item)) : null"
                                                        class="px-3 py-1 text-gray-600 hover:bg-gray-50 disabled:opacity-50"
                                                        :disabled="item.quantity >= item.product_variant.stock">+</button>
                                                </div>

                                                <form
                                                    :action="`{{ route('cart.destroy', ':id') }}`.replace(':id', item.id)"
                                                    method="POST" @submit.prevent="deleteItem($event)">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                                        <x-heroicon-o-trash class="h-5 w-5" />
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                </template>
                            </ul>
                        </div>

                        <div class="xl:col-span-1">
                            <div class="sticky top-28">
                                <div class="rounded-xl bg-white p-6 shadow-sm">
                                    <h2 class="text-xl font-semibold text-gray-900">Ringkasan Belanja</h2>
                                    <dl class="mt-6 space-y-3">
                                        <div class="flex items-center justify-between">
                                            <dt class="text-sm text-gray-600">Total Harga (<span
                                                    x-text="selectedItems.length"></span> produk)</dt>
                                            <dd class="text-sm font-medium text-gray-900" x-text="formattedSubtotal"></dd>
                                        </div>
                                        <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                            <dt class="text-base font-semibold text-gray-900">Total Belanja</dt>
                                            <dd class="text-lg font-bold text-persada-primary" x-text="formattedSubtotal">
                                            </dd>
                                        </div>
                                    </dl>
                                    <div class="mt-6">
                                        <a href="{{ route('checkout.index') }}"
                                            :class="{
                                                'bg-persada-primary text-white hover:bg-persada-dark': selectedItems
                                                    .length > 0,
                                                'bg-gray-300 text-gray-500 cursor-not-allowed': selectedItems.length ===
                                                    0
                                            }"
                                            @click="if (selectedItems.length === 0) $event.preventDefault()"
                                            class="w-full flex items-center justify-center rounded-lg py-3 px-4 text-base font-medium shadow transition">
                                            Beli (<span x-text="selectedItems.length"></span>)
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>
@endsection


@push('scripts')
    <script>
        function cartManager(initialItems) {
            return {
                items: initialItems.map(item => ({
                    ...item,
                    saving: false,
                    debounce: null
                })),
                selectAll: false,
                init() {
                    this.updateSelectAllState();
                    this.$watch('items', () => this.updateSelectAllState(), {
                        deep: true
                    });
                },
                get totalItems() {
                    return this.items.length;
                },
                get selectedItems() {
                    return this.items.filter(item => item.selected);
                },
                get subtotal() {
                    return this.selectedItems.reduce((acc, item) => acc + (item.quantity * item.product_variant.price),
                        0);
                },
                get formattedSubtotal() {
                    return `Rp${new Intl.NumberFormat('id-ID').format(this.subtotal)}`;
                },
                updateSelectAllState() {
                    this.selectAll = this.totalItems > 0 && this.selectedItems.length === this.totalItems;
                },
                toggleSelectAll() {
                    this.items.forEach(item => item.selected = this.selectAll);
                    this.updateSelection();
                },
                updateSelection() {
                    clearTimeout(this.debounce);
                    this.debounce = setTimeout(async () => {
                        const selections = this.items.map(item => ({
                            id: item.id,
                            selected: item.selected
                        }));
                        await fetch('{{ route('cart.update-selection') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify({
                                selections
                            })
                        });
                    }, 500);
                },
                updateQuantity(item) {
                    clearTimeout(item.debounce);
                    item.debounce = setTimeout(async () => {
                        item.saving = true;
                        const response = await fetch(`/cart/${item.id}/update`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify({
                                quantity: item.quantity
                            })
                        });
                        item.saving = false;
                        if (!response.ok) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Memperbarui',
                                text: 'Stok produk tidak mencukupi.',
                            }).then(() => {
                                window.location.reload();
                            });
                        }
                    }, 1000);
                },
                deleteItem(event) {
                    const form = event.target;
                    Swal.fire({
                        title: 'Anda yakin?',
                        text: "Produk ini akan dihapus dari keranjang Anda.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#40916c',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    })
                },
                async deleteSelected() {
                    if (this.selectedItems.length === 0) return;

                    const result = await Swal.fire({
                        title: 'Anda yakin?',
                        text: `Anda akan menghapus ${this.selectedItems.length} produk yang dipilih.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#40916c',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    });

                    if (result.isConfirmed) {
                        const deletePromises = this.selectedItems.map(item =>
                            fetch(`/cart/${item.id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute(
                                            'content')
                                }
                            })
                        );
                        await Promise.all(deletePromises);
                        window.location.reload();
                    }
                }
            }
        }
    </script>
@endpush
