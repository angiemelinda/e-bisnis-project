@extends('layouts.admin')

@section('title', 'Pendapatan')
@section('header', 'Pendapatan')

@section('content')
<div class="space-y-6">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Pendapatan</p>
                    <p class="text-3xl font-bold text-orange-500">Rp {{ number_format($totalEarningsAll, 0, ',', '.') }}</p>
                </div>
                <div class="bg-orange-100 p-4 rounded-lg">
                    <i class="fas fa-money-bill-wave text-orange-500 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Dari Pesanan</p>
                    <p class="text-3xl font-bold text-blue-500">Rp {{ number_format($totalEarnings, 0, ',', '.') }}</p>
                </div>
                <div class="bg-blue-100 p-4 rounded-lg">
                    <i class="fas fa-shopping-cart text-blue-500 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Dari Order Items</p>
                    <p class="text-3xl font-bold text-green-500">Rp {{ number_format($totalFromOrders, 0, ',', '.') }}</p>
                </div>
                <div class="bg-green-100 p-4 rounded-lg">
                    <i class="fas fa-box text-green-500 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Earnings Chart -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Pendapatan Bulanan</h3>
        <div class="h-64 flex items-end justify-between gap-2">
            @foreach($monthlyEarnings as $earning)
            <div class="flex-1 flex flex-col items-center">
                <div class="w-full bg-orange-500 rounded-t" style="height: {{ $earning['total'] > 0 ? ($earning['total'] / max(array_column($monthlyEarnings, 'total')) * 200) : 10 }}px;"></div>
                <p class="text-xs text-gray-600 mt-2 text-center">{{ $earning['month'] }}</p>
                <p class="text-xs font-semibold text-gray-800 mt-1">Rp {{ number_format($earning['total'], 0, ',', '.') }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Transaksi Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentTransactions as $transaction)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $transaction['code'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="px-2 py-1 text-xs rounded-full {{ $transaction['type'] === 'pesanan' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($transaction['type']) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">Rp {{ number_format($transaction['amount'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                {{ ucfirst(str_replace('_', ' ', $transaction['status'])) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction['date']->format('d M Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

