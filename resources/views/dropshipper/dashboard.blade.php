@extends('layouts.dropshipper')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')

<!-- Kartu Statistik -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
    <div class="bg-white shadow rounded-lg p-5 flex justify-between items-center">
        <div>
            <p class="text-gray-500">Order Dibuat</p>
            <p class="text-2xl font-bold text-orange-500">{{ $ordersCreated ?? 0 }}</p>
        </div>
        <div class="bg-orange-100 p-3 rounded-full">
            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 7h18M3 12h18M3 17h18"></path>
            </svg>
        </div>
    </div>
    <div class="bg-white shadow rounded-lg p-5 flex justify-between items-center">
        <div>
            <p class="text-gray-500">Order Dikirim</p>
            <p class="text-2xl font-bold text-orange-500">{{ $ordersShipped ?? 0 }}</p>
        </div>
        <div class="bg-orange-100 p-3 rounded-full">
            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 17v-6h13v6"></path>
            </svg>
        </div>
    </div>
    <div class="bg-white shadow rounded-lg p-5 flex justify-between items-center">
        <div>
            <p class="text-gray-500">Order Selesai</p>
            <p class="text-2xl font-bold text-orange-500">{{ $ordersCompleted ?? 0 }}</p>
        </div>
        <div class="bg-orange-100 p-3 rounded-full">
            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
    </div>
</div>

<!-- Tombol Pesan Barang -->
<div class="flex justify-end mb-4">
    <a href="{{ route('dropshipper.order-items') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded shadow">Pesan Barang</a>
</div>

<!-- Tabel Riwayat Order -->
<div class="bg-white shadow rounded-lg p-5 overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-orange-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">ID Order</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Supplier</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Produk</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Jumlah</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Tanggal</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($orders as $order)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $order->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $order->supplier->name ?? '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $order->product->name ?? '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $order->quantity }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    @if($order->status == 'created')
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Dibuat</span>
                    @elseif($order->status == 'shipped')
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Dikirim</span>
                    @elseif($order->status == 'completed')
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $order->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $orders->links() }}
</div>

@endsection
