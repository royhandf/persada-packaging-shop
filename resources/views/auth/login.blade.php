@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <div class="mb-8 text-left md:text-center">
        <h2 class="font-display text-2xl md:text-3xl font-bold text-gray-800">Masuk ke Akun Anda</h2>
        <p class="text-gray-500 mt-2">Gunakan email dan password Anda.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block font-display text-sm font-medium text-gray-700">Email</label>
            <div class="mt-1 relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <x-heroicon-s-envelope class="h-5 w-5 text-gray-400" />
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    placeholder="user@mail.com"
                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-green-500 focus:border-green-500 transition placeholder:text-gray-400">
            </div>
            @error('email')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block font-display text-sm font-medium text-gray-700">Password</label>
            <div class="mt-1 relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <x-heroicon-s-lock-closed class="h-5 w-5 text-gray-400" />
                </span>
                <input id="password" type="password" name="password" required placeholder="••••••••"
                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-green-500 focus:border-green-500 transition placeholder:text-gray-400">
            </div>
        </div>

        <div class="flex items-center justify-between text-sm">
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox"
                    class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary">
                <label for="remember" class="ml-2 block text-gray-600">Ingat saya</label>
            </div>
            <a href="{{ route('register') }}" class="font-medium text-green-600 hover:underline">Buat akun baru</a>
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full bg-persada-primary text-white font-display font-semibold py-2.5 px-4 rounded-md 
               hover:bg-persada-dark-hover focus:outline-none focus:ring-2 focus:ring-persada-accent 
               focus:ring-offset-2 transition cursor-pointer">
                Masuk
            </button>
        </div>
    </form>
@endsection
