@extends('layouts.admin')

@section('title', 'Pengaturan Toko')

@section('content')
    <div class="space-y-8">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Pengaturan Toko</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Kelola konfigurasi bisnis untuk pembayaran dan pengiriman di sini.
            </p>
        </div>

        <form action="{{ route('settings.update') }}" method="POST" x-data="shippingOrigin()" x-init="init()">
            @csrf
            <div class="space-y-8">
                <div class="bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">Pengaturan Pengiriman
                        </h3>
                        <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-9">

                            <div class="sm:col-span-3">
                                <label for="shipping_origin_province"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Provinsi Asal</label>
                                <select name="shipping_origin_province" id="shipping_origin_province"
                                    x-model="selectedProvince" @change="loadCities()"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-persada-primary focus:ring-persada-primary sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                    <option value="">-- Pilih Provinsi --</option>
                                    <template x-for="province in provinces" :key="province.id">
                                        <option :value="province.id" x-text="province.name"></option>
                                    </template>
                                </select>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="shipping_origin_city"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kota/Kabupaten
                                    Asal</label>
                                <select name="shipping_origin_city" id="shipping_origin_city" x-model="selectedCity"
                                    @change="loadDistricts()" :disabled="!selectedProvince || cities.length === 0"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-persada-primary focus:ring-persada-primary sm:text-sm disabled:bg-gray-100 dark:disabled:bg-gray-800 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                    <option value="">-- Pilih Kota --</option>
                                    <template x-for="city in cities" :key="city.id">
                                        <option :value="city.id" x-text="city.name"></option>
                                    </template>
                                </select>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="shipping_origin_district"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kecamatan
                                    Asal</label>
                                <select name="shipping_origin_district" id="shipping_origin_district"
                                    x-model="selectedDistrict" :disabled="!selectedCity || districts.length === 0"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-persada-primary focus:ring-persada-primary sm:text-sm disabled:bg-gray-100 dark:disabled:bg-gray-800 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                    <option value="">-- Pilih Kecamatan --</option>
                                    <template x-for="district in districts" :key="district.id">
                                        <option :value="district.id" x-text="district.name"></option>
                                    </template>
                                </select>
                            </div>

                            <div class="sm:col-span-9">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kurir yang
                                    Diaktifkan</label>
                                <div class="mt-2 space-y-2">
                                    <div class="flex items-center gap-x-3">
                                        <input id="shipping_jne_active" name="shipping_jne_active" type="checkbox"
                                            value="1"
                                            {{ isset($settings['shipping_jne_active']) && $settings['shipping_jne_active'] == '1' ? 'checked' : '' }}
                                            class="h-4 w-4 rounded border-gray-300 text-persada-primary focus:ring-persada-primary">
                                        <label for="shipping_jne_active"
                                            class="block text-sm text-gray-900 dark:text-gray-200">JNE</label>
                                    </div>
                                    <div class="flex items-center gap-x-3">
                                        <input id="shipping_jnt_active" name="shipping_jnt_active" type="checkbox"
                                            value="1"
                                            {{ isset($settings['shipping_jnt_active']) && $settings['shipping_jnt_active'] == '1' ? 'checked' : '' }}
                                            class="h-4 w-4 rounded border-gray-300 text-persada-primary focus:ring-persada-primary">
                                        <label for="shipping_jnt_active"
                                            class="block text-sm text-gray-900 dark:text-gray-200">J&T</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">Pengaturan Pembayaran
                        </h3>
                        <div class="mt-2 space-y-2">
                            <div class="flex items-center gap-x-3">
                                <input id="payment_bca_active" name="payment_bca_active" type="checkbox" value="1"
                                    {{ isset($settings['payment_bca_active']) && $settings['payment_bca_active'] == '1' ? 'checked' : '' }}
                                    class="h-4 w-4 rounded border-gray-300 text-persada-primary focus:ring-persada-primary">
                                <label for="payment_bca_active"
                                    class="block text-sm text-gray-900 dark:text-gray-200">Transfer Bank BCA</label>
                            </div>
                            <div class="flex items-center gap-x-3">
                                <input id="payment_qris_active" name="payment_qris_active" type="checkbox" value="1"
                                    {{ isset($settings['payment_qris_active']) && $settings['payment_qris_active'] == '1' ? 'checked' : '' }}
                                    class="h-4 w-4 rounded border-gray-300 text-persada-primary focus:ring-persada-primary">
                                <label for="payment_qris_active"
                                    class="block text-sm text-gray-900 dark:text-gray-200">QRIS</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="rounded-md bg-persada-primary px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-persada-primary/80">
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
                provinces: [],
                cities: [],
                districts: [],

                selectedProvince: '{{ $settings['shipping_origin_province'] ?? '' }}',
                selectedCity: '{{ $settings['shipping_origin_city'] ?? '' }}',
                selectedDistrict: '{{ $settings['shipping_origin_district'] ?? '' }}',

                async init() {
                    try {
                        const response = await fetch('/provinces');
                        const json = await response.json();
                        const sortedProvinces = json.data.sort((a, b) => a.name.localeCompare(b
                            .name));
                        this.provinces = sortedProvinces;
                        if (this.selectedProvince) {
                            await this.loadCities();
                        }
                    } catch (error) {
                        console.error('Gagal memuat provinsi:', error);
                    }
                },

                async loadCities() {
                    this.cities = [];
                    this.districts = [];
                    if (!this.selectedProvince) return;

                    try {
                        const response = await fetch(`/cities/${this.selectedProvince}`);
                        const json = await response.json();
                        const sortedCities = json.data.sort((a, b) => a.name.localeCompare(b.name));
                        this.cities = sortedCities;

                        if (this.selectedCity) {
                            await this.loadDistricts();
                        }
                    } catch (error) {
                        console.error('Gagal memuat kota:', error);
                    }
                },

                async loadDistricts() {
                    this.districts = [];
                    if (!this.selectedCity) return;

                    try {
                        const response = await fetch(`/districts/${this.selectedCity}`);
                        const json = await response.json();
                        const sortedDistricts = json.data.sort((a, b) => a.name.localeCompare(b
                            .name));
                        this.districts = sortedDistricts;
                    } catch (error) {
                        console.error('Gagal memuat kecamatan:', error);
                    }
                }
            }));
        });
    </script>
@endpush
