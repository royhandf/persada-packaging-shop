@extends('layouts.admin')

@section('title', 'Pengaturan Toko')

@section('content')
    <div class="space-y-10">
        {{-- Header Halaman --}}
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                Pengaturan Toko
            </h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Kelola konfigurasi bisnis untuk pembayaran dan pengiriman di sini.
            </p>
        </div>

        <form action="{{ route('settings.update') }}" method="POST" x-data="shippingOrigin()" x-init="init()">
            @csrf
            <div class="space-y-6">
                {{-- KARTU PENGATURAN PENGIRIMAN --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="p-6 space-y-6">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Pengaturan Pengiriman</h2>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Atur lokasi asal pengiriman dan kurir yang akan digunakan oleh toko Anda.
                            </p>
                        </div>

                        <div class="grid gap-6 sm:grid-cols-2">
                            {{-- Detail Alamat --}}
                            <div class="sm:col-span-2">
                                <label for="shipping_origin_address"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Detail Alamat Gudang/Toko (Nama Jalan, No. Rumah)
                                </label>
                                <textarea id="shipping_origin_address" name="shipping_origin_address" rows="3"
                                    placeholder="Contoh: Jl. Merdeka No. 10 RT 02 RW 03"
                                    class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-persada-primary focus:ring-persada-primary sm:text-sm">{{ $settings['shipping_origin_address'] ?? '' }}</textarea>
                            </div>

                            {{-- Pencarian Lokasi --}}
                            <div class="sm:col-span-2 relative">
                                <label for="shipping_origin_area"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Kecamatan / Kota / Provinsi Asal
                                </label>
                                <input type="text" id="shipping_origin_area" x-model="query"
                                    @input.debounce.500ms="search"
                                    placeholder="Ketik untuk mencari lokasi (contoh: Beji, Depok)"
                                    class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-persada-primary focus:ring-persada-primary sm:text-sm">
                                <input type="hidden" name="shipping_origin_area_id" x-model="selectedId">
                                <input type="hidden" name="shipping_origin_area_name" x-model="query">
                                <ul x-show="results.length > 0" x-cloak
                                    class="absolute z-20 mt-1 w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow-lg max-h-60 overflow-auto">
                                    <template x-for="(item, index) in results" :key="item.id + '-' + index">
                                        <li>
                                            <button type="button" @click="select(item)"
                                                class="w-full text-left px-3 py-2 text-sm hover:bg-persada-primary hover:text-white rounded">
                                                <span x-text="item.name"></span>
                                            </button>
                                        </li>
                                    </template>
                                </ul>
                            </div>

                            {{-- Peta Pinpoint --}}
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pinpoint
                                    Lokasi Asal di Peta</label>
                                <div id="map"
                                    class="h-64 w-full rounded-lg border border-gray-300 dark:border-gray-600"></div>
                                <input type="hidden" id="latitude" name="shipping_origin_latitude" x-model="latitude">
                                <input type="hidden" id="longitude" name="shipping_origin_longitude" x-model="longitude">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KARTU PENGATURAN LAIN --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="p-6 space-y-6">
                        {{-- Kurir --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Kurir yang Diaktifkan
                            </label>
                            <div class="mt-3 grid grid-cols-2 sm:grid-cols-4 gap-4">
                                @php
                                    $availableCouriers = [
                                        'jne' => 'JNE',
                                        'jnt' => 'J&T',
                                        'sicepat' => 'SiCepat',
                                        'anteraja' => 'AnterAja',
                                    ];
                                    $activeCouriers = isset($settings['shipping_active_couriers'])
                                        ? json_decode($settings['shipping_active_couriers'], true)
                                        : [];
                                @endphp
                                @foreach ($availableCouriers as $code => $label)
                                    <label for="courier_{{ $code }}"
                                        class="flex items-center gap-2 rounded-lg border border-gray-200 dark:border-gray-600 px-3 py-2 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <input id="courier_{{ $code }}" name="shipping_active_couriers[]"
                                            type="checkbox" value="{{ $code }}"
                                            {{ in_array($code, $activeCouriers ?? []) ? 'checked' : '' }}
                                            class="h-4 w-4 rounded text-persada-primary focus:ring-persada-primary border-gray-300 dark:border-gray-500">
                                        <span class="text-sm text-gray-900 dark:text-gray-200">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Pengaturan Pembayaran</h2>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Pilih metode pembayaran yang tersedia.
                            </p>
                            <div class="mt-3 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                                @php
                                    $availablePayments = [
                                        'payment_bca_va_active' => 'Bank Transfer BCA',
                                        'payment_bri_va_active' => 'Bank Transfer BRI',
                                        'payment_bni_va_active' => 'Bank Transfer BNI',
                                        'payment_mandiri_va_active' => 'Bank Transfer Mandiri',
                                        'payment_qris_active' => 'QRIS',
                                        'payment_gopay_active' => 'GoPay',
                                        'payment_shopeepay_active' => 'ShopeePay',
                                        'payment_dana_active' => 'DANA',
                                    ];
                                @endphp

                                @foreach ($availablePayments as $key => $label)
                                    <label for="{{ $key }}"
                                        class="flex items-center gap-2 rounded-lg border border-gray-200 dark:border-gray-600 px-3 py-2 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <input id="{{ $key }}" name="{{ $key }}" type="checkbox"
                                            value="1"
                                            {{ isset($settings[$key]) && $settings[$key] == '1' ? 'checked' : '' }}
                                            class="h-4 w-4 rounded text-persada-primary focus:ring-persada-primary border-gray-300 dark:border-gray-500">
                                        <span class="text-sm text-gray-900 dark:text-gray-200">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Simpan --}}
                <div class="flex justify-end pt-2">
                    <button type="submit"
                        class="rounded-lg bg-persada-primary px-6 py-2.5 text-sm font-semibold text-white shadow hover:bg-persada-primary/90 focus:outline-none focus:ring-2 focus:ring-persada-primary">
                        Simpan Pengaturan
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('shippingOrigin', () => ({
                query: '{{ $settings['shipping_origin_area_name'] ?? '' }}',
                selectedId: '{{ $settings['shipping_origin_area_id'] ?? '' }}',
                latitude: '{{ $settings['shipping_origin_latitude'] ?? -7.6433 }}',
                longitude: '{{ $settings['shipping_origin_longitude'] ?? 112.9064 }}',
                results: [],
                map: null,
                marker: null,

                init() {
                    this.initMap();
                },

                initMap() {
                    const initialPosition = [parseFloat(this.latitude), parseFloat(this.longitude)];

                    this.map = L.map('map').setView(initialPosition, 15);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(this.map);

                    this.marker = L.marker(initialPosition, {
                        draggable: true
                    }).addTo(this.map);

                    this.marker.on('dragend', (e) => {
                        const pos = e.target.getLatLng();
                        this.latitude = pos.lat;
                        this.longitude = pos.lng;
                    });
                },

                async search() {
                    if (this.query.length < 3) {
                        this.results = [];
                        return;
                    }
                    try {
                        const res = await fetch(
                            `{{ route('settings.search-location') }}?q=${encodeURIComponent(this.query)}`
                        );
                        const data = await res.json();
                        this.results = data.areas || [];
                    } catch (e) {
                        console.error('Gagal cari lokasi:', e);
                    }
                },

                select(item) {
                    this.query = item.name;
                    this.selectedId = item.id;
                    this.results = [];
                }
            }));
        });
    </script>
@endpush
