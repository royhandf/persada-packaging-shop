@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Manajemen Pesanan</h1>
    </div>

    <div class="mt-4 border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex space-x-6 overflow-x-auto" aria-label="Tabs">
            <a href="{{ route('dashboard.orders.index') }}"
                class="shrink-0 border-b-2 px-1 pb-4 text-sm font-medium {{ !$currentStatus ? 'border-persada-primary text-persada-primary' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:text-gray-200' }}">
                Semua
            </a>
            @foreach ($statuses as $status)
                <a href="{{ route('dashboard.orders.index', ['status' => $status]) }}"
                    class="shrink-0 border-b-2 px-1 pb-4 text-sm font-medium {{ $currentStatus === $status ? 'border-persada-primary text-persada-primary' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:text-gray-200' }}">
                    {{ Str::title(str_replace('_', ' ', $status)) }}
                </a>
            @endforeach
        </nav>
    </div>

    <div class="mt-6 overflow-x-auto bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                        No. Pesanan</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                        Pelanggan</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                        Tanggal</th>
                    <th
                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                        Total</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                        Status</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                        Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                @forelse ($orders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200 font-semibold">
                            #{{ $order->order_number }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                            {{ $order->user->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $order->created_at->translatedFormat('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200 text-right">Rp
                            {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span @class([
                                'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' => in_array(
                                    $order->status,
                                    ['completed', 'delivered']),
                                'bg-cyan-100 text-cyan-800 dark:bg-cyan-900 dark:text-cyan-200' =>
                                    $order->status == 'paid',
                                'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' => in_array(
                                    $order->status,
                                    ['shipped', 'processing']),
                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' =>
                                    $order->status == 'pending_payment',
                                'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' => in_array(
                                    $order->status,
                                    ['cancelled', 'refunded']),
                                'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' => !in_array(
                                    $order->status,
                                    [
                                        'completed',
                                        'delivered',
                                        'paid',
                                        'shipped',
                                        'processing',
                                        'pending_payment',
                                        'cancelled',
                                        'refunded',
                                    ]),
                            ])>
                                {{ Str::title(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                            <a href="{{ route('dashboard.orders.show', $order->order_number) }}" title="Lihat Detail"
                                class="p-1.5 rounded bg-blue-500 text-white hover:bg-blue-600 inline-block">
                                @svg('heroicon-o-eye', 'w-4 h-4')
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                            Tidak ada pesanan yang cocok dengan filter ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
@endsection
