@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <h1 class="font-display text-3xl font-bold text-gray-900">@yield('title', 'Dashboard')</h1>
        <p class="text-gray-600 mt-1">Selamat datang kembali, mari kita lihat statistik hari ini.</p>
    </div>
@endsection

@push('scripts')
    @if (session('auth_success'))
        <script type="module">
            window.addEventListener("DOMContentLoaded", () => {
                window.notyf.success(@json(session('auth_success')));
            });
        </script>
    @endif
@endpush
