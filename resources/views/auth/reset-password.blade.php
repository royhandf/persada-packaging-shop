@extends('layouts.guest')

@section('title', 'Reset Password')

@section('imageOrderClass', 'md:flex-row-reverse')

@section('content')
    <div class="mb-8 text-left md:text-center">
        <h2 class="font-display text-2xl md:text-3xl font-bold text-gray-800">Atur Password Baru Anda</h2>
        <p class="text-gray-500 mt-2">Pastikan password baru Anda kuat dan mudah diingat.</p>
    </div>

    <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label for="email" class="block font-display text-sm font-medium text-gray-700">Email</label>
            <div class="mt-1">
                <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus
                    placeholder="user@mail.com"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-green-500 focus:border-green-500 transition placeholder:text-gray-400">
            </div>
        </div>

        <div>
            <label for="password" class="block font-display text-sm font-medium text-gray-700">Password Baru</label>
            <div class="mt-1">
                <input id="password" type="password" name="password" required placeholder="••••••••"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-green-500 focus:border-green-500 transition placeholder:text-gray-400">
            </div>
        </div>

        <div>
            <label for="password_confirmation" class="block font-display text-sm font-medium text-gray-700">Konfirmasi
                Password</label>
            <div class="mt-1">
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    placeholder="••••••••"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-green-500 focus:border-green-500 transition placeholder:text-gray-400">
            </div>
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full bg-persada-primary text-white font-display font-semibold py-2.5 px-4 rounded-md hover:bg-persada-dark-hover transition">
                Reset Password
            </button>
        </div>
    </form>
@endsection
