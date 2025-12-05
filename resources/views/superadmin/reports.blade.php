@extends('layouts.superadmin')

@section('title', 'Laporan')
@section('header', 'Laporan')

@section('content')
<!-- Filter Tanggal -->
<div class="bg-white shadow rounded-lg p-5 mb-6">
    <form action="{{ route('superadmin.reports.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-center">
        <div>
            <label class="block text-gray-700 font-medium mb-1">Dari Tanggal</label>
            <input type="date" name="from" class="border rounded px-3 py-2 w-full sm:w-64">
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-1">Sampai Tanggal</label>
            <input type="date" name="to" class="border rounded px-3 py-2 w-full sm:w-64">
        </div>
        <div class="mt-4 sm:mt-0">
            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded shadow">Filter</button>
        </div>
    </form>
</div>

<!-- Ringkasan Laporan -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white shadow rounded-lg p-5 flex items-center justify-between">
        <div>
            <p class="text-gray-500">Total Produk Terjual</p>
            <p class="text-2xl font-bold text-orange-500">{{ $totalProductsSold ?? 0 }}</p>
        </div>
        <div class="bg-orange-100 p-3 rounded-full">
            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </div>
    </div>
    <div class="bg-white shadow rounded-lg p-5 flex items-center justify-between">
        <div>
            <p class="text-gray-500">Total Transaksi</p>
            <p class="text-2xl font-bold text-orange-500">{{ $totalTransactions ?? 0 }}</p>
        </div>
        <div class="bg-orange-100 p-3 rounded-full">
            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
    </div>
    <div class="bg-white shadow rounded-lg p-5 flex items-center justify-between">
        <div>
            <p class="text-gray-500">Pendapatan</p>
            <p class="text-2xl font-bold text-orange-500">${{ number_format($totalRevenue ?? 0, 2) }}</p>
        </div>
        <div class="bg-orange-100 p-3 rounded-full">
            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z"></path>
            </svg>
        </div>
    </div>
    <div class="bg-white shadow rounded-lg p-5 flex items-center justify-between">
        <div>
            <p class="text-gray-500">Dropshipper Aktif</p>
            <p class="text-2xl font-bold text-orange-500">{{ $activeDropshippers ?? 0 }}</p>
        </div>
        <div class="bg-orange-100 p-3 rounded-full">
            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 3h18v18H3z"></path>
            </svg>
        </div>
    </div>
</div>

<!-- Tabel Laporan -->
<div class="bg-white shadow rounded-lg p-5 overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-orange-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Dropshipper</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Produk Terjual</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Total Transaksi</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Pendapatan</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($reportData as $report)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $report->date }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $report->dropshipper_name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $report->products_sold }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $report->transactions_count }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${{ number_format($report->revenue,2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $reportData->links() }}
</div>
@endsection
