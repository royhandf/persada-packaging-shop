@extends('layouts.admin')

@section('title', 'Profil Akun')

@section('content')
    <div class="space-y-8">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                Profil Akun
            </h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Perbarui informasi profil dan alamat email akun Anda.
            </p>
        </div>

        <div class="bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">
                    Informasi Profil
                </h3>
                <form action="{{ route('profile.update') }}" method="POST" class="mt-6 space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                        <input id="name" name="name" type="text" value="{{ old('name', auth()->user()->name) }}"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 bg-white text-gray-900 shadow-sm focus:border-persada-primary focus:ring-persada-primary sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat
                            Email</label>
                        <input id="email" name="email" type="email"
                            value="{{ old('email', auth()->user()->email) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 bg-white text-gray-900 shadow-sm focus:border-persada-primary focus:ring-persada-primary sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">No.
                            Telepon</label>
                        <input id="phone" name="phone" type="tel"
                            value="{{ old('phone', auth()->user()->phone) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 bg-white text-gray-900 shadow-sm focus:border-persada-primary focus:ring-persada-primary sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                        @error('phone')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit"
                            class="cursor-pointer rounded-md bg-persada-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-persada-dark-hover focus-visible:outline-offset-2 focus-visible:outline-persada-primary">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">
                    Ubah Password
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                    Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.
                </p>
                <form action="{{ route('profile.password.update') }}" method="POST" class="mt-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password Saat Ini</label>
                        <input id="current_password" name="current_password" type="password" required
                            class="mt-1 block w-full rounded-md border-gray-300 bg-white text-gray-900 shadow-sm focus:border-persada-primary focus:ring-persada-primary sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                        @error('current_password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password
                            Baru</label>
                        <input id="password" name="password" type="password" required
                            class="mt-1 block w-full rounded-md border-gray-300 bg-white text-gray-900 shadow-sm focus:border-persada-primary focus:ring-persada-primary sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Konfirmasi Password
                            Baru</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            class="mt-1 block w-full rounded-md border-gray-300 bg-white text-gray-900 shadow-sm focus:border-persada-primary focus:ring-persada-primary sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit"
                            class="cursor-pointer rounded-md bg-persada-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-persada-dark-hover focus-visible:outline-offset-2 focus-visible:outline-persada-primary">
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
