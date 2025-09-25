@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
    <div class="bg-gray-50 pt-36 pb-24">
        <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="border-b border-gray-200 pb-8 mb-8">
                <h1 class="text-3xl font-bold font-display tracking-tight text-gray-900 sm:text-4xl">Riwayat Pesanan Saya
                </h1>
                <p class="mt-4 max-w-3xl text-base text-gray-500">Lacak dan lihat detail semua transaksi Anda di sini.</p>
            </div>

            <div class="mb-8">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-6 overflow-x-auto" aria-label="Tabs">
                        <a href="{{ route('order.index') }}" @class([
                            'whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium',
                            'border-persada-primary text-persada-primary' => !request('status'),
                            'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' => request(
                                'status'),
                        ])>
                            Semua
                        </a>
                        <a href="{{ route('order.index', ['status' => 'unpaid']) }}" @class([
                            'whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium',
                            'border-persada-primary text-persada-primary' =>
                                request('status') == 'unpaid',
                            'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' =>
                                request('status') != 'unpaid',
                        ])>
                            Belum Dibayar
                        </a>
                        <a href="{{ route('order.index', ['status' => 'processing']) }}" @class([
                            'whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium',
                            'border-persada-primary text-persada-primary' =>
                                request('status') == 'processing',
                            'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' =>
                                request('status') != 'processing',
                        ])>
                            Diproses
                        </a>
                        <a href="{{ route('order.index', ['status' => 'shipped']) }}" @class([
                            'whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium',
                            'border-persada-primary text-persada-primary' =>
                                request('status') == 'shipped',
                            'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' =>
                                request('status') != 'shipped',
                        ])>
                            Dikirim
                        </a>
                        <a href="{{ route('order.index', ['status' => 'completed']) }}" @class([
                            'whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium',
                            'border-persada-primary text-persada-primary' =>
                                request('status') == 'completed',
                            'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' =>
                                request('status') != 'completed',
                        ])>
                            Selesai
                        </a>
                    </nav>
                </div>
            </div>

            <div class="space-y-6">
                @forelse ($orders as $order)
                    <div class="bg-white rounded-xl shadow-sm transition hover:shadow-lg overflow-hidden">
                        <div class="p-6 flex flex-col md:flex-row gap-6">
                            @if ($order->items->isNotEmpty())
                                @php $firstItem = $order->items->first(); @endphp
                                <img src="{{ optional(optional(optional($firstItem)->productVariant)->product)->primaryImage ? asset('storage/' . $firstItem->productVariant->product->primaryImage->image_path) : asset('images/default-product.png') }}"
                                    alt="{{ $firstItem->product_name ?? 'Produk Dihapus' }}"
                                    class="w-full h-48 md:w-40 md:h-40 object-cover rounded-lg flex-shrink-0">
                            @endif

                            <div class="flex-grow grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                <div>
                                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Nomor Pesanan</p>
                                    <p class="font-bold text-persada-dark mt-1">#{{ $order->order_number }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Tanggal</p>
                                    <p class="font-semibold text-gray-700 mt-1">{{ $order->created_at->format('d M Y') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Total</p>
                                    <p class="font-bold text-gray-900 mt-1">
                                        Rp{{ number_format($order->grand_total, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Status</p>
                                    <div class="mt-1">
                                        <span @class([
                                            'px-3 py-1 text-xs font-bold rounded-full inline-flex items-center gap-1.5',
                                            'bg-yellow-100 text-yellow-800' => $order->status === 'pending_payment',
                                            'bg-green-100 text-green-800' => $order->status === 'paid',
                                            'bg-blue-100 text-blue-800' => $order->status === 'processing',
                                            'bg-indigo-100 text-indigo-800' => $order->status === 'shipped',
                                            'bg-teal-100 text-teal-800' => $order->status === 'delivered',
                                            'bg-slate-200 text-slate-800' => $order->status === 'completed',
                                            'bg-red-100 text-red-800' => $order->status === 'cancelled',
                                            'bg-gray-100 text-gray-800' => $order->status === 'refunded',
                                        ])>
                                            @switch($order->status)
                                                @case('pending_payment')
                                                    <x-heroicon-s-clock class="h-3.5 w-3.5" />
                                                @break

                                                @case('paid')
                                                    <x-heroicon-s-check-circle class="h-3.5 w-3.5" />
                                                @break

                                                @case('processing')
                                                    <x-heroicon-s-archive-box class="h-3.5 w-3.5" />
                                                @break

                                                @case('shipped')
                                                    <x-heroicon-s-truck class="h-3.5 w-3.5" />
                                                @break

                                                @case('delivered')
                                                    <x-heroicon-s-home-modern class="h-3.5 w-3.5" />
                                                @break

                                                @case('completed')
                                                    <x-heroicon-s-sparkles class="h-3.5 w-3.5" />
                                                @break

                                                @case('cancelled')
                                                    <x-heroicon-s-x-circle class="h-3.5 w-3.5" />
                                                @break

                                                @case('refunded')
                                                    <x-heroicon-s-arrow-uturn-left class="h-3.5 w-3.5" />
                                                @break
                                            @endswitch
                                            {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 flex items-center justify-end">
                            <a href="{{ route('order.detail', $order) }}"
                                class="bg-persada-primary text-white font-semibold py-2 px-5 rounded-lg text-sm transition hover:bg-persada-dark">
                                Lihat Detail Pesanan
                            </a>
                        </div>
                    </div>
                    @empty
                        <div class="text-center py-20 border-2 border-dashed rounded-xl bg-white">
                            <x-heroicon-o-inbox class="mx-auto h-12 w-12 text-gray-400" />
                            <h3 class="mt-4 text-lg font-semibold text-gray-900">Tidak Ada Pesanan</h3>
                            <p class="mt-1 text-sm text-gray-500">Anda belum memiliki pesanan dengan status ini.</p>
                        </div>
                    @endforelse
                </div>

                @if ($orders->hasPages())
                    <div class="mt-8">
                        {{ $orders->links() }}
                    </div>
                @endif
            </main>
        </div>
    @endsection
