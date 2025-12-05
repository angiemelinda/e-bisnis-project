@extends('layouts.dropshipper')

@section('title', 'Order Barang')
@section('header', 'Order Barang')

@section('content')

<div class="bg-white shadow rounded-lg p-5 mb-6">
    <form action="{{ route('dropshipper.order-items.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @csrf
        <div>
            <label class="block text-gray-700 font-medium mb-1">Produk</label>
            <select name="product_id" class="border rounded px-3 py-2 w-full">
                @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }} - {{ $product->supplier->name ?? '-' }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-1">Jumlah</label>
            <input type="number" name="quantity" min="1" value="1" class="border rounded px-3 py-2 w-full">
        </div>
        <div class="sm:col-span-2 flex justify-end mt-4">
            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded shadow">Pesan Barang</button>
        </div>
    </form>
</div>

<!-- Riwayat Order Sebelumnya -->
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

<div class="mt-4">
    {{ $orders->links() }}
</div>

@endsection
