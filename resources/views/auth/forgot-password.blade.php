@extends('layouts.guest')

@section('title', 'Reset Password')

@section('content')
    <div class="mb-8 text-left md:text-center">
        <h2 class="font-display text-2xl md:text-3xl font-bold text-gray-800">Lupa Password Anda?</h2>
        <p class="text-gray-500 mt-2">Jangan khawatir. Masukkan email Anda dan kami akan mengirimkan link untuk mereset
            password.</p>
    </div>

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf
        <div>
            <label for="email" class="block font-display text-sm font-medium text-gray-700">Email</label>
            <div class="mt-1">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    placeholder="user@mail.com"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-green-500 focus:border-green-500 transition placeholder:text-gray-400">
            </div>
        </div>
        <div class="pt-2">
            <button type="submit"
                class="w-full bg-persada-primary text-white font-display font-semibold py-2.5 px-4 rounded-md hover:bg-persada-dark-hover transition">
                Kirim Link Reset Password
            </button>
        </div>
    </form>

    <div class="mt-6 text-center text-sm">
        <p class="text-gray-600">
            Tiba-tiba ingat password Anda?
            <a href="{{ route('login') }}" class="font-medium text-green-600 hover:underline">
                Kembali ke Login
            </a>
        </p>
    </div>
@endsection
