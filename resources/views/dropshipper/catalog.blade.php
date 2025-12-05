@extends('layouts.dropshipper')

@section('title', 'Katalog Produk')
@section('header', 'Katalog Produk')

@section('content')
<!-- Filter / Search Produk -->
<div class="bg-white shadow rounded-lg p-5 mb-6">
    <form action="{{ route('dropshipper.catalog') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-center">
        <input type="text" name="search" placeholder="Cari produk..." class="border rounded px-3 py-2 w-full sm:w-64">
        <select name="category" class="border rounded px-3 py-2 w-full sm:w-48">
            <option value="">Semua Kategori</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded shadow">Filter</button>
    </form>
</div>

<!-- Tabel Katalog Produk -->
<div class="bg-white shadow rounded-lg p-5 overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-orange-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Gambar</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Nama Produk</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Supplier</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Stok</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Harga</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($products as $product)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded">
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $product->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $product->supplier->name ?? '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $product->stock }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${{ number_format($product->price,2) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <a href="{{ route('dropshipper.order-items', $product->id) }}" class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-1 rounded">Pesan</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $products->links() }}
</div>
@endsection
