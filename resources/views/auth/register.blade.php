@extends('layouts.guest')

@section('title', 'Register')

@section('imageOrderClass', 'md:flex-row-reverse')

@section('content')
    <div class="mb-8 text-left md:text-center">
        <h2 class="font-display text-2xl md:text-3xl font-bold text-gray-800">Buat Akun Baru</h2>
        <p class="text-gray-500 mt-2">Mulai perjalanan Anda bersama kami.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf
        <div>
            <label for="name" class="block font-display text-sm font-medium text-gray-700">Nama Lengkap</label>
            <div class="mt-1 relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <x-heroicon-s-user class="h-5 w-5 text-gray-400" />
                </span>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    placeholder="Nama Anda"
                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition placeholder:text-gray-400">
            </div>
            @error('name')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block font-display text-sm font-medium text-gray-700">Email</label>
            <div class="mt-1 relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <x-heroicon-s-envelope class="h-5 w-5 text-gray-400" />
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    placeholder="user@mail.com"
                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition placeholder:text-gray-400">
            </div>
            @error('email')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block font-display text-sm font-medium text-gray-700">Password</label>
            <div class="mt-1 relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <x-heroicon-s-lock-closed class="h-5 w-5 text-gray-400" />
                </span>
                <input id="password" type="password" name="password" required placeholder="••••••••"
                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition placeholder:text-gray-400">
            </div>
            @error('password')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block font-display text-sm font-medium text-gray-700">Konfirmasi
                Password</label>
            <div class="mt-1 relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <x-heroicon-s-lock-closed class="h-5 w-5 text-gray-400" />
                </span>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    placeholder="••••••••"
                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition placeholder:text-gray-400">
            </div>
        </div>

        <div class="text-sm text-center">
            <p class="text-gray-600">Sudah punya akun?
                <a href="{{ route('login') }}" class="font-medium text-green-600 hover:underline">Masuk
                    di sini</a>
            </p>
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full bg-persada-primary text-white font-display font-semibold py-2.5 px-4 rounded-md 
               hover:bg-persada-dark-hover focus:outline-none focus:ring-2 focus:ring-persada-accent 
               focus:ring-offset-2 transition cursor-pointer">
                Buat Akun
            </button>
        </div>
    </form>
@endsection
