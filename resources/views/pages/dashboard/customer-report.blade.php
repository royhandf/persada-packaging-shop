@extends('layouts.admin')

@section('title', 'Laporan Pelanggan')

@section('content')
    <div class="space-y-8">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-gray-100">Laporan Pelanggan</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Analisis pertumbuhan dan perilaku pelanggan dalam rentang waktu tertentu.
            </p>
        </div>

        <div class="border-b border-gray-200 pb-5 dark:border-gray-700">
            <form method="GET" action="{{ route('reports.customers') }}"
                class="flex flex-col gap-4 md:flex-row md:items-end">
                <div class="grid flex-grow grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal
                            Mulai</label>
                        <input type="date" name="start_date" id="start_date" value="{{ $startDate->format('Y-m-d') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-persada-primary focus:ring-persada-primary sm:text-sm dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-persada-primary">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal
                            Selesai</label>
                        <input type="date" name="end_date" id="end_date" value="{{ $endDate->format('Y-m-d') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-persada-primary focus:ring-persada-primary sm:text-sm dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-persada-primary">
                    </div>
                </div>
                <div class="flex flex-shrink-0 items-center gap-2 pt-4 md:pt-0">
                    <button type="submit"
                        class="inline-flex w-full items-center justify-center rounded-md border border-transparent bg-persada-primary px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-persada-dark-hover focus:outline-none focus:ring-2 focus:ring-persada-primary focus:ring-offset-2 dark:focus:ring-offset-gray-900 sm:w-auto">
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <x-kpi-card metric="orders" title="Pelanggan Baru" :value="$newCustomersCount" />
            <x-kpi-card metric="shipping" title="Pelanggan Berulang" :value="$returningCustomersCount" />
            <x-kpi-card metric="products" title="Total Pelanggan Aktif" :value="$newCustomersCount + $returningCustomersCount" />
        </div>

        <div class="rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Komposisi Pelanggan</h3>
            <div class="mt-4 h-80"><canvas id="customerCompositionChart"></canvas></div>
        </div>

        <div>
            <h2 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-100">Daftar Pelanggan Terbaik
                (Berdasarkan Total Belanja)</h2>
            <div class="mt-4 overflow-hidden rounded-lg bg-white shadow-sm dark:bg-gray-800">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800/70">
                        <tr>
                            <th scope="col"
                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-200 sm:pl-6">
                                Peringkat</th>
                            <th scope="col"
                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">Nama
                                Pelanggan</th>
                            <th scope="col"
                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">Tanggal
                                Bergabung</th>
                            <th scope="col"
                                class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900 dark:text-gray-200">Jml
                                Pesanan</th>
                            <th scope="col"
                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">Total
                                Belanja</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                        @forelse ($customers as $customer)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td
                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-gray-200 sm:pl-6">
                                    {{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 dark:text-gray-200">
                                    <div class="font-medium">{{ $customer->name }}</div>
                                    <div class="text-gray-500">{{ $customer->email }}</div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $customer->created_at->translatedFormat('d M Y') }}</td>
                                <td
                                    class="whitespace-nowrap px-3 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    {{ $customer->orders_count }}</td>
                                <td
                                    class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-900 dark:text-gray-200">
                                    Rp {{ number_format($customer->orders_sum_grand_total, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="py-20 text-center">
                                        @svg('heroicon-o-users', 'mx-auto h-12 w-12 text-gray-400')
                                        <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Tidak ada
                                            data pelanggan</h3>
                                        <p class="mt-1 text-sm text-gray-500">Tidak ada pelanggan yang melakukan transaksi
                                            pada rentang tanggal ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($customers->hasPages())
                <div class="mt-5">
                    {{ $customers->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isDarkMode = document.documentElement.classList.contains('dark');
            const labelColor = isDarkMode ? '#9ca3af' : '#6b7280';

            const customerCtx = document.getElementById('customerCompositionChart');
            if (customerCtx) {
                new Chart(customerCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Pelanggan Baru', 'Pelanggan Berulang'],
                        datasets: [{
                            data: [
                                {{ $newCustomersCount }},
                                {{ $returningCustomersCount }}
                            ],
                            backgroundColor: ['#34d399', '#60a5fa'],
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    color: labelColor
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush
