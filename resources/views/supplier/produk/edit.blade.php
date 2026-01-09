@extends('layouts.admin')

@section('title', 'Edit Produk')
@section('header', 'Edit Produk')

@section('content')
<div class="bg-white p-6 rounded-lg shadow max-w-2xl">
    @if ($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('supplier.produk.update', $produk->id) }}">
        @csrf
        @method('PUT')
        <div class="space-y-4">
            <div>
                <label class="block mb-1 font-medium text-gray-700">Nama Produk <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $produk->name) }}" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-transparent" required>
            </div>
            
            <div>
                <label class="block mb-1 font-medium text-gray-700">Kategori</label>
                <select name="category_id" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $produk->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Harga <span class="text-red-500">*</span></label>
                    <input type="number" name="price" value="{{ old('price', $produk->price) }}" step="0.01" min="0" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-transparent" required>
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', $produk->stock) }}" min="0" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-transparent" required>
                </div>
            </div>
            
            <div>
                <label class="block mb-1 font-medium text-gray-700">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="active" {{ old('status', $produk->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ old('status', $produk->status) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
        </div>
        
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('supplier.produk.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg shadow">
                Update
            </button>
        </div>
    </form>
</div>
@endsection