@extends('layouts.app')

@section('title', 'Kelola Stok')

@section('content')
<h2 class="text-3xl font-bold text-gray-800 mb-6">Kelola Stok</h2>

<div class="bg-white shadow rounded-lg overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-orange-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Produk</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok Saat Ini</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Update Stok</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($products as $product)
            <tr>
                <td class="px-6 py-4">{{ $product->name }}</td>
                <td class="px-6 py-4">{{ $product->stock }}</td>
                <td class="px-6 py-4">
                    <form action="{{ route('admin.stock.update', $product->id) }}" method="POST" class="flex space-x-2">
                        @csrf
                        @method('PUT')
                        <input type="number" name="stock" value="{{ $product->stock }}" class="border px-2 py-1 rounded w-20">
                        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-1 rounded shadow">Update</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
