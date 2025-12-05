@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<h2 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Admin</h2>

<!-- Statistik Kartu -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-sm font-medium text-gray-500">Total Produk</h3>
        <p class="mt-2 text-2xl font-bold text-orange-600">{{ $totalProducts }}</p>
    </div>
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-sm font-medium text-gray-500">Total Supplier</h3>
        <p class="mt-2 text-2xl font-bold text-orange-600">{{ $totalSuppliers }}</p>
    </div>
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-sm font-medium text-gray-500">Produk Aktif</h3>
        <p class="mt-2 text-2xl font-bold text-green-600">{{ $activeProducts }}</p>
    </div>
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-sm font-medium text-gray-500">Produk Nonaktif</h3>
        <p class="mt-2 text-2xl font-bold text-red-600">{{ $inactiveProducts }}</p>
    </div>
</div>

<!-- Produk Terbaru -->
<div class="bg-white shadow rounded-lg overflow-x-auto">
    <h3 class="text-xl font-bold text-gray-800 p-6 border-b">Produk Terbaru</h3>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-orange-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gambar</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Produk</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Supplier</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($latestProducts as $product)
            <tr>
                <td class="px-6 py-4"><img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded"></td>
                <td class="px-6 py-4">{{ $product->name }}</td>
                <td class="px-6 py-4">{{ $product->supplier->name }}</td>
                <td class="px-6 py-4">{{ $product->stock }}</td>
                <td class="px-6 py-4">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="px-6 py-4">
                    @if($product->status)
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Aktif</span>
                    @else
                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Nonaktif</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
