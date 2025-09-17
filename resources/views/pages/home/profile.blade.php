@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <div class="bg-gray-50 pt-36 pb-24">
        <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="border-b border-gray-200 pb-8 mb-8">
                <h1 class="text-3xl font-bold font-display tracking-tight text-gray-900 sm:text-4xl">Akun Saya</h1>
                <p class="mt-4 max-w-3xl text-base text-gray-500">Kelola informasi akun, alamat, dan riwayat pesanan Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <aside class="lg:col-span-1">
                    @include('layouts.partials.app-sidebar', ['active' => 'profile'])
                </aside>

                <div class="lg:col-span-3 space-y-8">
                    <section class="bg-white p-6 sm:p-8 rounded-xl shadow-sm">
                        <header>
                            <h2 class="text-xl font-bold text-gray-900">Informasi Profil</h2>
                            <p class="mt-1 text-sm text-gray-500">Perbarui data profil dan alamat email akun Anda.</p>
                        </header>
                        <form method="POST" action="{{ route('customer.profile.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('PATCH')
                            <div><label for="name" class="block text-sm font-medium text-gray-700">Nama
                                    Lengkap</label><input type="text" id="name" name="name"
                                    value="{{ old('name', auth()->user()->name) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-persada-primary focus:ring-persada-primary sm:text-sm">
                                @error('name')
                                    <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div><label for="email" class="block text-sm font-medium text-gray-700">Alamat
                                    Email</label><input type="email" id="email" name="email"
                                    value="{{ old('email', auth()->user()->email) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-persada-primary focus:ring-persada-primary sm:text-sm">
                                @error('email')
                                    <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div><label for="phone" class="block text-sm font-medium text-gray-700">Nomor
                                    Telepon</label><input type="tel" id="phone" name="phone"
                                    value="{{ old('phone', auth()->user()->phone) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-persada-primary focus:ring-persada-primary sm:text-sm">
                                @error('phone')
                                    <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex items-center gap-4"><button type="submit"
                                    class="inline-flex justify-center rounded-lg border border-transparent bg-persada-primary py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-persada-dark">Simpan
                                    Perubahan</button>
                            </div>
                        </form>
                    </section>

                    <section class="bg-white p-6 sm:p-8 rounded-xl shadow-sm">
                        <header>
                            <h2 class="text-xl font-bold text-gray-900">Ubah Password</h2>
                            <p class="mt-1 text-sm text-gray-500">Pastikan akun Anda menggunakan password yang panjang dan
                                acak agar tetap aman.</p>
                        </header>
                        <form method="POST" action="{{ route('customer.profile.password.update') }}"
                            class="mt-6 space-y-6">
                            @csrf
                            @method('PUT')
                            <div><label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat
                                    Ini</label><input type="password" id="current_password" name="current_password" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-persada-primary focus:ring-persada-primary sm:text-sm">
                                @error('current_password', 'updatePassword')
                                    <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div><label for="password" class="block text-sm font-medium text-gray-700">Password
                                    Baru</label><input type="password" id="password" name="password" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-persada-primary focus:ring-persada-primary sm:text-sm">
                                @error('password', 'updatePassword')
                                    <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div><label for="password_confirmation"
                                    class="block text-sm font-medium text-gray-700">Konfirmasi Password</label><input
                                    type="password" id="password_confirmation" name="password_confirmation" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-persada-primary focus:ring-persada-primary sm:text-sm">
                            </div>
                            <div class="flex items-center gap-4"><button type="submit"
                                    class="inline-flex justify-center rounded-lg border border-transparent bg-persada-primary py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-persada-dark">Simpan
                                    Password</button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </main>
    </div>
@endsection

@push('scripts')
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: '{{ session('success') }}',
                    timer: 2500,
                    showConfirmButton: false
                });
            });
        </script>
    @endif
@endpush
