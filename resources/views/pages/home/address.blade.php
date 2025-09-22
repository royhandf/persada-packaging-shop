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
                                        {{ $address->street_address }}, {{ $address->area_name }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0 flex flex-col items-end justify-between gap-2">
                                    <form action="{{ route('customer.profile.address.destroy', $address) }}" method="POST"
                                        onsubmit="return confirm('Anda yakin ingin menghapus alamat ini?')">
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
                <div x-show="isModalOpen" x-transition.opacity class="fixed inset-0 bg-gray-500/75"></div>
                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div @click.outside="closeModal()" x-show="isModalOpen" x-transition
                            class="relative transform rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                            <form :action="formAction" method="POST" class="w-full">
                                @csrf
                                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4" x-data="addressForm()"
                                    x-init="init()">
                                    <h3 class="text-lg font-semibold leading-6 text-gray-900">Tambah Alamat Baru</h3>
                                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div class="sm:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700">Label Alamat</label>
                                            <input type="text" name="label" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Nama Penerima</label>
                                            <input type="text" name="receiver_name" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                            <input type="tel" name="phone" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700">Alamat Lengkap (Nama
                                                Jalan, No. Rumah)</label>
                                            <textarea name="street_address" rows="3" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm"></textarea>
                                        </div>
                                        <div class="sm:col-span-2 relative">
                                            <label class="block text-sm font-medium text-gray-700">Kecamatan / Kota /
                                                Provinsi</label>
                                            <input type="text" x-model="query" @input.debounce.500ms="search"
                                                placeholder="Cari kecamatan/kota (contoh: Beji, Depok)" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                            <input type="hidden" name="area_id" x-model="selectedId">
                                            <input type="hidden" name="area_name" x-model="selectedName">
                                            <ul x-show="results.length > 0" x-cloak
                                                class="absolute z-30 mt-1 w-full bg-white border rounded-lg shadow-lg max-h-60 overflow-auto">
                                                <template x-for="(item, index) in results" :key="item.id + '-' + index">
                                                    <li><button type="button" @click="select(item)"
                                                            class="w-full text-left px-3 py-2 text-sm hover:bg-persada-primary hover:text-white rounded"><span
                                                                x-text="item.name"></span></button></li>
                                                </template>
                                            </ul>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Pin Point Lokasi di
                                                Peta</label>
                                            <div id="map" class="h-64 w-full rounded-md border"></div>
                                            <input type="hidden" name="latitude" id="latitude">
                                            <input type="hidden" name="longitude" id="longitude">
                                        </div>
                                        <div class="sm:col-span-2 flex items-center">
                                            <input type="checkbox" name="is_primary" value="1"
                                                class="h-4 w-4 rounded border-gray-300 text-persada-primary focus:ring-persada-primary">
                                            <label class="ml-2 block text-sm text-gray-900">Jadikan alamat utama</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                    <button type="submit"
                                        class="inline-flex w-full justify-center rounded-md bg-persada-primary px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-persada-dark sm:ml-3 sm:w-auto">Simpan
                                        Alamat</button>
                                    <button type="button" @click="closeModal()"
                                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Batal</button>
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
                openModal() {
                    this.isModalOpen = true;
                    this.$nextTick(() => {
                        window.dispatchEvent(new CustomEvent('modal-opened'));
                    });
                },
                closeModal() {
                    this.isModalOpen = false;
                }
            }
        }

        function addressForm() {
            return {
                query: '',
                results: [],
                selectedId: '',
                selectedName: '',
                map: null,
                marker: null,

                init() {
                    window.addEventListener('modal-opened', () => {
                        setTimeout(() => this.initMap(), 150);
                    });
                },

                initMap() {
                    if (this.map) this.map.remove();

                    const latInput = document.getElementById('latitude');
                    const lngInput = document.getElementById('longitude');
                    const initialPosition = [-7.6433, 112.9064];

                    this.map = L.map('map').setView(initialPosition, 15);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(this.map);

                    this.marker = L.marker(initialPosition, {
                        draggable: true
                    }).addTo(this.map);
                    latInput.value = initialPosition[0];
                    lngInput.value = initialPosition[1];

                    this.marker.on('dragend', (e) => {
                        const pos = e.target.getLatLng();
                        latInput.value = pos.lat;
                        lngInput.value = pos.lng;
                    });
                },

                async search() {
                    if (this.query.length < 3) {
                        this.results = [];
                        return;
                    }
                    const res = await fetch(
                        `{{ route('customer.profile.search-location') }}?q=${encodeURIComponent(this.query)}`);
                    const data = await res.json();
                    this.results = data || [];
                },

                select(item) {
                    this.selectedId = item.id;
                    this.selectedName = item.name;
                    this.query = item.name;
                    this.results = [];
                }
            }
        }
    </script>
@endpush
