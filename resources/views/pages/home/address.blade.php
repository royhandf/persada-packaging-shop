@extends('layouts.app')
@section('title', 'Alamat Saya')

@section('content')
    <div class="bg-gray-50 pt-36 pb-24" x-data="addressPageManager({{ $addresses }})">
        <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="border-b border-gray-200 pb-8 mb-8">
                <h1 class="text-3xl font-bold font-display tracking-tight text-gray-900 sm:text-4xl">Akun Saya</h1>
                <p class="mt-4 max-w-3xl text-base text-gray-500">
                    Kelola informasi akun, alamat, dan riwayat pesanan Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <aside class="lg:col-span-1">
                    @include('layouts.partials.app-sidebar', ['active' => 'address'])
                </aside>

                <div class="lg:col-span-3">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Daftar Alamat</h2>
                        <button @click="openModal()"
                            class="inline-flex justify-center rounded-lg border border-transparent bg-persada-primary py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-persada-dark">
                            Tambah Alamat Baru
                        </button>
                    </div>
                    <div class="space-y-4">
                        @forelse ($addresses as $address)
                            <div class="bg-white p-5 rounded-xl shadow-sm flex flex-col sm:flex-row justify-between gap-4">
                                <div>
                                    <div class="flex items-center gap-x-3">
                                        <p class="font-bold text-gray-800">{{ $address->label }}</p>
                                        @if ($address->is_primary)
                                            <span
                                                class="inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-700">Utama</span>
                                        @endif
                                    </div>
                                    <p class="mt-2 font-semibold">{{ $address->receiver_name }}</p>
                                    <p class="text-sm text-gray-500">{{ $address->phone }}</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $address->street_address }},
                                        {{ $address->subdistrict }}, {{ $address->city }},
                                        {{ $address->province }}, {{ $address->postal_code }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0 flex sm:flex-col items-center sm:items-end justify-between gap-2">
                                    <form action="{{ route('customer.profile.address.destroy', $address) }}" method="POST"
                                        onsubmit="return confirm('Anda yakin?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-sm font-medium text-red-600 hover:text-red-800">Hapus</button>
                                    </form>
                                    @unless ($address->is_primary)
                                        <form action="{{ route('customer.profile.address.setPrimary', $address) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="text-xs font-medium text-gray-500 hover:text-persada-primary border rounded-full px-3 py-1">
                                                Set sebagai utama
                                            </button>
                                        </form>
                                    @endunless
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-16 px-6 bg-white rounded-xl shadow-sm">
                                <x-heroicon-o-map-pin class="mx-auto h-12 w-12 text-gray-400" />
                                <h3 class="mt-2 text-lg font-medium text-gray-900">Belum Ada Alamat</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Mulai dengan menambahkan alamat baru untuk pengiriman.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div x-show="isModalOpen" class="relative z-50" x-cloak>
                <div x-show="isModalOpen" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div @click.outside="closeModal()" x-show="isModalOpen" x-transition
                            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                            <form :action="formAction" method="POST" class="w-full">
                                @csrf
                                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4" x-data="addressForm()">
                                    <h3 class="text-lg font-semibold leading-6 text-gray-900">Tambah Alamat Baru</h3>
                                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div class="sm:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700">Label Alamat</label>
                                            <input type="text" x-model="address.label" name="label" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Nama Penerima</label>
                                            <input type="text" x-model="address.receiver_name" name="receiver_name"
                                                required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                            <input type="tel" x-model="address.phone" name="phone" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                                            <textarea x-model="address.street_address" name="street_address" rows="3" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm"></textarea>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Provinsi</label>
                                            <select name="province_id" x-model="selectedProvince" @change="getCities"
                                                required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                                <option value="" disabled>Pilih Provinsi</option>
                                                <template x-for="province in provinces" :key="province.id">
                                                    <option :value="province.id" x-text="province.name"></option>
                                                </template>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                                            <select name="city_id" x-model="selectedCity" @change="getDistricts"
                                                :disabled="!cities.length" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                                <option value="" disabled>Pilih Kota/Kabupaten</option>
                                                <template x-for="city in cities" :key="city.id">
                                                    <option :value="city.id" x-text="city.name"></option>
                                                </template>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Kecamatan</label>
                                            <select name="subdistrict_id" x-model="selectedDistrict"
                                                :disabled="!districts.length" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                                <option value="" disabled>Pilih Kecamatan</option>
                                                <template x-for="district in districts" :key="district.id">
                                                    <option :value="district.id" x-text="district.name"></option>
                                                </template>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Kode Pos</label>
                                            <input type="text" x-model="address.postal_code" name="postal_code" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                        </div>

                                        <input type="hidden" name="province"
                                            :value="getSelectedName(provinces, selectedProvince)">
                                        <input type="hidden" name="city"
                                            :value="getSelectedName(cities, selectedCity)">
                                        <input type="hidden" name="subdistrict"
                                            :value="getSelectedName(districts, selectedDistrict)">

                                        <div class="sm:col-span-2 flex items-center">
                                            <input type="hidden" name="is_primary" :value="address.is_primary ? 1 : 0">

                                            <input type="checkbox" x-model="address.is_primary"
                                                class="h-4 w-4 rounded border-gray-300 text-persada-primary focus:ring-persada-primary">
                                            <label class="ml-2 block text-sm text-gray-900">Jadikan alamat utama</label>
                                        </div>

                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                    <button type="submit"
                                        class="inline-flex w-full justify-center rounded-md bg-persada-primary px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-persada-dark sm:ml-3 sm:w-auto">
                                        Simpan Alamat
                                    </button>
                                    <button type="button" @click="closeModal()"
                                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection

@push('scripts')
    <script>
        function addressPageManager(addresses) {
            return {
                isModalOpen: false,
                formAction: '{{ route('customer.profile.address.store') }}',
                address: {},
                openModal() {
                    this.address = {
                        label: '',
                        receiver_name: '',
                        phone: '',
                        street_address: '',
                        province_id: '',
                        city_id: '',
                        subdistrict_id: '',
                        postal_code: '',
                        is_primary: false
                    };
                    this.isModalOpen = true;
                    this.$nextTick(() => {
                        window.dispatchEvent(new CustomEvent('modal-opened', {
                            detail: {
                                address: this.address
                            }
                        }));
                    });
                },
                closeModal() {
                    this.isModalOpen = false;
                }
            }
        }

        function addressForm() {
            return {
                provinces: [],
                cities: [],
                districts: [],
                selectedProvince: '',
                selectedCity: '',
                selectedDistrict: '',
                address: {},

                init() {
                    this.getProvinces();
                    window.addEventListener('modal-opened', (event) => {
                        this.address = event.detail.address;
                        this.selectedProvince = '';
                        this.selectedCity = '';
                        this.selectedDistrict = '';
                    });
                },
                async getProvinces() {
                    const response = await fetch('{{ route('api.provinces') }}');
                    const data = await response.json();
                    this.provinces = data.data || [];
                },
                async getCities() {
                    this.cities = [];
                    this.districts = [];
                    this.selectedCity = '';
                    this.selectedDistrict = '';
                    if (!this.selectedProvince) return;
                    const response = await fetch(`{{ url('/cities') }}/${this.selectedProvince}`);
                    const data = await response.json();
                    this.cities = data.data || [];
                },
                async getDistricts() {
                    this.districts = [];
                    this.selectedDistrict = '';
                    if (!this.selectedCity) return;
                    const response = await fetch(`{{ url('/districts') }}/${this.selectedCity}`);
                    const data = await response.json();
                    this.districts = data.data || [];
                },
                getSelectedName(collection, id) {
                    if (!id || !collection.length) return '';
                    const item = collection.find(i => i.id == id);
                    return item ? item.name : '';
                }
            }
        }
    </script>
@endpush
