@extends('layouts.guest')

@section('title', 'Verifikasi Email Anda')

@section('content')
    <div class="mb-8 text-left md:text-center">
        <h2 class="font-display text-2xl md:text-3xl font-bold text-gray-800">Verifikasi Alamat Email Anda</h2>
        <p class="text-gray-500 mt-2">
            Sebelum melanjutkan, silakan periksa email Anda untuk menemukan link verifikasi.
        </p>
    </div>

    <div class="space-y-4 text-center">
        <p class="text-gray-600">
            Jika Anda tidak menerima email, klik tombol di bawah untuk mengirim ulang.
        </p>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit"
                class="w-full bg-persada-primary text-white font-display font-semibold py-2.5 px-4 rounded-md hover:bg-persada-dark-hover transition">
                Kirim Email Verifikasi
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 hover:underline">
                Logout
            </button>
        </form>
    </div>
@endsection
