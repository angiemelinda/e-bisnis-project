@extends('layouts.dropshipper')

@section('title', 'Riwayat Order')
@section('header', 'Riwayat Order')

@section('content')

<!-- Filter Status / Tanggal -->
<div class="bg-white shadow rounded-lg p-5 mb-6">
    <form action="{{ route('dropshipper.order-history') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-center">
        <select name="status" class="border rounded px-3 py-2 w-full sm:w-48">
            <option value="">Semua Status</option>
            <option value="created">Dibuat</option>
            <option value="shipped">Dikirim</option>
            <option value="completed">Selesai</option>
        </select>
        <input type="date" name="from" class="border rounded px-3 py-2 w-full sm:w-48" placeholder="Dari Tanggal">
        <input type="date" name="to" class="border rounded px-3 py-2 w-full sm:w-48" placeholder="Sampai Tanggal">
        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded shadow">Filter</button>
    </form>
</div>

<!-- Tabel Riwayat Order -->
<div class="bg-white shadow rounded-lg p-5 overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-orange-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">ID Order</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Produk</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Jumlah</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Supplier</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Tanggal</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($orders as $order)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $order->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $order->product->name ?? '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $order->quantity }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $order->product->supplier->name ?? '-' }}</td>
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
