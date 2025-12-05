@extends('layouts.app')

@section('title', 'Kategori Produk')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold text-gray-800">Kategori Produk</h2>
    <a href="{{ route('admin.categories.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded shadow transition">Tambah Kategori</a>
</div>

<div class="bg-white shadow rounded-lg overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-orange-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Kategori</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($categories as $category)
            <tr>
                <td class="px-6 py-4">{{ $category->name }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded shadow text-sm">Edit</a>
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline">
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
