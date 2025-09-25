@extends('layouts.app')
@section('title', 'Checkout')

@push('head')
    <script type="text/javascript"
        src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
@endpush

@section('content')
    <div class="bg-gray-50 pt-36 pb-32" x-data="checkoutManager({{ $addresses->toJson() }}, {{ $primaryAddress ? "'" . $primaryAddress->id . "'" : 'null' }}, {{ $cartItems->sum(fn($i) => $i->productVariant->price * $i->quantity) }})">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form @submit.prevent="processCheckout" x-ref="checkoutForm"
                class="grid grid-cols-1 lg:grid-cols-3 gap-x-8 gap-y-10 items-start">
                @csrf

                <input type="hidden" name="address_id" x-model="selectedAddressId">
                <input type="hidden" name="shipping_rate" x-model="selectedCourierJson">
                <input type="hidden" name="payment_method" x-model="selectedPayment">

                <div class="lg:col-span-2 space-y-8">
                    <section class="bg-white p-6 rounded-xl shadow-sm">
                        <h2 class="text-xl font-semibold mb-4 text-gray-800">1. Alamat Pengiriman</h2>
                        @if ($addresses->isNotEmpty())
                            <div class="space-y-3">
                                @foreach ($addresses as $address)
                                    <label
                                        class="flex items-start space-x-4 border rounded-lg p-4 cursor-pointer transition-all duration-200"
                                        :class="{
                                            'border-persada-primary ring-2 ring-persada-primary': selectedAddressId ==
                                                '{{ $address->id }}'
                                        }">
                                        <input type="radio" name="address_id_radio" value="{{ $address->id }}"
                                            x-model="selectedAddressId" @change="getShippingRates"
                                            class="mt-1 text-persada-primary focus:ring-persada-primary">
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $address->receiver_name }}
                                                ({{ $address->label }})
                                            </p>
                                            <p class="text-sm text-gray-600">{{ $address->phone }}</p>
                                            <p class="text-sm text-gray-600 mt-1">{{ $address->street_address }},
                                                {{ $address->area_name }}</p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500">Anda belum memiliki alamat. <a
                                    href="{{ route('customer.profile.address.index') }}"
                                    class="text-persada-primary font-medium hover:underline">Tambah alamat sekarang</a>.</p>
                        @endif
                    </section>

                    <section class="bg-white p-6 rounded-xl shadow-sm">
                        <h2 class="text-xl font-semibold mb-4 text-gray-800">2. Opsi Pengiriman</h2>
                        <div x-show="loading" class="text-center py-4 text-gray-500">Memuat opsi pengiriman...</div>
                        <div x-show="!loading && shippingRates.length > 0" x-cloak class="space-y-3">
                            <template x-for="rate in shippingRates" :key="rate.courier_service_code">
                                <label class="flex items-start space-x-4 border rounded-lg p-4 cursor-pointer transition"
                                    :class="{
                                        'border-persada-primary ring-2 ring-persada-primary': selectedCourier &&
                                            selectedCourier.courier_service_code == rate.courier_service_code
                                    }">
                                    <input type="radio" name="shipping_rate_radio" :value="JSON.stringify(rate)"
                                        x-model="selectedCourierJson"
                                        class="mt-1 text-persada-primary focus:ring-persada-primary">
                                    <div class="w-full">
                                        <p class="font-medium"
                                            x-text="`${rate.courier_name} - ${rate.courier_service_name}`"></p>
                                        <p class="text-sm text-gray-500" x-text="`Estimasi ${rate.duration}`"></p>
                                        <p class="text-sm font-semibold mt-1" x-text="`Rp${formatCurrency(rate.price)}`">
                                        </p>
                                    </div>
                                </label>
                            </template>
                        </div>
                        <div x-show="!loading && error" x-cloak class="text-red-500 text-sm" x-text="error"></div>
                        <div x-show="!loading && shippingRates.length === 0 && !error && selectedAddressId" x-cloak
                            class="text-gray-500 text-sm">Tidak ada opsi pengiriman yang tersedia untuk alamat ini.</div>
                        <div x-show="!loading && !selectedAddressId" class="text-gray-500 text-sm">Pilih alamat terlebih
                            dahulu untuk melihat opsi pengiriman.</div>
                    </section>

                    <section class="bg-white p-6 rounded-xl shadow-sm">
                        <h2 class="text-xl font-semibold mb-4 text-gray-800">3. Metode Pembayaran</h2>
                        @if (!empty($activePaymentMethods))
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach ($activePaymentMethods as $code => $label)
                                    <label
                                        class="flex items-center gap-3 border rounded-lg p-4 cursor-pointer transition hover:bg-gray-50"
                                        :class="{ 'border-persada-primary ring-2 ring-persada-primary': selectedPayment === '{{ $code }}' }">
                                        <input type="radio" name="payment_method" value="{{ $code }}"
                                            x-model="selectedPayment"
                                            class="text-persada-primary focus:ring-persada-primary">
                                        <span class="text-sm font-medium text-gray-900">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500">Belum ada metode pembayaran yang tersedia.</p>
                        @endif
                    </section>
                </div>

                <div class="lg:col-span-1 space-y-8">
                    <div>
                        <div class="bg-white rounded-xl shadow-sm p-6 sticky top-28">
                            <h2 class="text-xl font-semibold mb-5 text-gray-800">Ringkasan Pesanan</h2>
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium text-gray-900" x-text="`Rp${formatCurrency(subtotal)}`"></span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Ongkos Kirim</span>
                                    <span class="font-medium text-gray-900"
                                        x-text="selectedCourier ? `Rp${formatCurrency(selectedCourier.price)}` : 'Pilih Alamat'"></span>
                                </div>
                                <div class="flex justify-between font-bold text-base border-t pt-3 mt-3">
                                    <span>Total</span>
                                    <span x-text="`Rp${formatCurrency(grandTotal)}`"></span>
                                </div>
                            </div>
                            <button type="submit" :disabled="!isFormComplete() || isProcessing"
                                class="w-full mt-6 bg-persada-primary text-white py-3 px-6 rounded-lg font-semibold hover:bg-persada-dark transition disabled:bg-gray-400 disabled:cursor-not-allowed flex items-center justify-center">
                                <span x-show="!isProcessing">Bayar Sekarang</span>
                                <span x-show="isProcessing" class="flex items-center">
                                    <x-heroicon-s-cog-6-tooth class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" />
                                    Memproses...
                                </span>
                            </button>
                        </div>
                    </div>

                    <section class="bg-white p-6 rounded-xl shadow-sm">
                        <h3 class="text-xl font-semibold mb-5 text-gray-800">Produk Pesanan</h3>
                        <ul class="space-y-5">
                            @foreach ($cartItems as $item)
                                <li class="flex items-start gap-4">
                                    <img src="{{ $item->productVariant->product->primaryImage ? asset('storage/' . $item->productVariant->product->primaryImage->image_path) : asset('images/default-product.png') }}"
                                        alt="{{ $item->productVariant->product->name }}"
                                        class="h-16 w-16 object-cover rounded-md border">
                                    <div class="flex-1">
                                        <p class="font-medium text-sm text-gray-800">
                                            {{ $item->productVariant->product->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->productVariant->name }}</p>
                                        <p class="text-sm font-semibold text-gray-900 mt-1">
                                            Rp{{ number_format($item->productVariant->price, 0, ',', '.') }}
                                        </p>
                                        <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </section>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function checkoutManager(addresses, primaryAddressId, cartSubtotal) {
            return {
                loading: false,
                error: '',
                addresses: addresses,
                selectedAddressId: primaryAddressId,
                shippingRates: [],
                selectedCourier: null,
                selectedCourierJson: '',
                selectedPayment: '',
                subtotal: cartSubtotal,
                isProcessing: false,

                get grandTotal() {
                    return this.subtotal + (this.selectedCourier ? this.selectedCourier.price : 0);
                },

                isFormComplete() {
                    return this.selectedAddressId && this.selectedCourier && this.selectedPayment;
                },

                init() {
                    if (this.selectedAddressId) {
                        this.getShippingRates();
                    }
                    this.$watch('selectedCourierJson', (value) => {
                        this.selectedCourier = value ? JSON.parse(value) : null;
                    });
                },

                formatCurrency(number) {
                    return new Intl.NumberFormat('id-ID').format(number);
                },

                async getShippingRates() {
                    if (!this.selectedAddressId) return;
                    this.loading = true;
                    this.shippingRates = [];
                    this.selectedCourier = null;
                    this.selectedCourierJson = '';
                    this.error = '';

                    try {
                        const response = await fetch('{{ route('checkout.calculate-shipping') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                address_id: this.selectedAddressId
                            })
                        });
                        const data = await response.json();
                        if (!response.ok) throw new Error(data.message || 'Gagal memuat ongkir.');
                        this.shippingRates = data.pricing || [];
                        if (this.shippingRates.length === 0) {
                            this.error = 'Tidak ada layanan kurir yang tersedia untuk tujuan ini.';
                        }
                    } catch (e) {
                        this.error = e.message;
                    } finally {
                        this.loading = false;
                    }
                },

                async processCheckout() {
                    if (!this.isFormComplete()) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Form Belum Lengkap',
                            text: 'Harap lengkapi semua informasi: alamat, pengiriman, dan metode pembayaran.',
                        });
                        return;
                    }

                    this.isProcessing = true;
                    this.error = '';
                    const formData = new FormData(this.$refs.checkoutForm);

                    try {
                        const response = await fetch('{{ route('checkout.store') }}', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        });
                        const data = await response.json();
                        if (!response.ok) throw new Error(data.message ||
                            `Terjadi kesalahan (Error ${response.status})`);

                        if (data.snap_token) {
                            window.snap.pay(data.snap_token, {
                                onSuccess: (result) => {
                                    const successUrl = "{{ url('orders') }}/" + result.order_id +
                                        "?status=success";
                                    window.location.href = successUrl;
                                },
                                onPending: (result) => {
                                    const pendingUrl = "{{ url('orders') }}/" + result.order_id +
                                        "?status=pending";
                                    window.location.href = pendingUrl;
                                },
                                onError: (result) => {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Pembayaran Gagal',
                                        text: 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.',
                                    });
                                },
                                onClose: () => {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Pembayaran Ditutup',
                                        text: 'Anda menutup jendela pembayaran sebelum transaksi selesai.',
                                    });
                                }
                            });
                        }
                    } catch (e) {
                        this.error = e.message;
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops... Terjadi Kesalahan',
                            text: e.message,
                        });
                    } finally {
                        this.isProcessing = false;
                    }
                }
            }
        }
    </script>
@endpush
