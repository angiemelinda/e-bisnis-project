@extends('layouts.app')

@section('title', 'Dashboard Super Admin')

@section('header', 'Dashboard')

@section('content')
<!-- Statistik Kartu -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white shadow rounded-lg p-5 flex items-center justify-between">
        <div>
            <p class="text-gray-500">Total Supplier</p>
            <p class="text-2xl font-bold text-orange-500">120</p>
        </div>
        <div class="bg-orange-100 p-3 rounded-full">
            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 3h18v18H3z"></path>
            </svg>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-5 flex items-center justify-between">
        <div>
            <p class="text-gray-500">Total Dropshipper</p>
            <p class="text-2xl font-bold text-orange-500">85</p>
        </div>
        <div class="bg-orange-100 p-3 rounded-full">
            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-5 flex items-center justify-between">
        <div>
            <p class="text-gray-500">Total Produk</p>
            <p class="text-2xl font-bold text-orange-500">500</p>
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
            <p class="text-2xl font-bold text-orange-500">1.200</p>
        </div>
        <div class="bg-orange-100 p-3 rounded-full">
            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 3h18v18H3z"></path>
            </svg>
        </div>
    </div>
</div>

<!-- Grafik Aktivitas Transaksi (dummy) -->
<div class="bg-white shadow rounded-lg p-5 mb-6">
    <h2 class="text-xl font-semibold text-gray-700 mb-4">Aktivitas Transaksi</h2>
    <div class="w-full h-64 bg-gray-100 flex items-center justify-center rounded">
        <span class="text-gray-400">[Dummy Chart]</span>
    </div>
</div>

<!-- Tabel Log Aktivitas Admin -->
<div class="bg-white shadow rounded-lg p-5">
    <h2 class="text-xl font-semibold text-gray-700 mb-4">Log Aktivitas Admin</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-orange-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Waktu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Pengguna</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">2025-12-05 10:00</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">admin1</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">2025-12-05 09:30</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">admin2</td>
                </tr>
                <!-- Tambahkan data log lain -->
            </tbody>
        </table>
    </div>
</div>
@endsection
