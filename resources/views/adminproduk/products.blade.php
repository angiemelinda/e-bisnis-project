@extends('layouts.app')

@section('title', 'Kelola Produk')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold text-gray-800">Kelola Produk</h2>
    <button onclick="openModal()" class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded shadow transition">Tambah Produk</button>
</div>

<div class="bg-white shadow rounded-lg overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-orange-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gambar</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Produk</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Supplier</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($products as $product)
            <tr>
                <td class="px-6 py-4"><img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded"></td>
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
                <td class="px-6 py-4">
                    <button onclick="editModal({{ $product->id }})" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded shadow text-sm">Edit</button>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow text-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
