@extends('layouts.admin')

@section('title', 'Tambah Produk')
@section('header', 'Tambah Produk Baru')

@section('content')
<form class="bg-white p-6 rounded-lg shadow max-w-lg" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-4">
        <label class="block mb-1 font-medium">Nama Produk</label>
        <input type="text" name="nama" class="w-full border rounded px-3 py-2" placeholder="Nama Produk" required>
    </div>
    <div class="mb-4">
        <label class="block mb-1 font-medium">Harga</label>
        <input type="number" name="harga" class="w-full border rounded px-3 py-2" placeholder="Harga Produk" required>
    </div>
    <div class="mb-4">
        <label class="block mb-1 font-medium">Stok</label>
        <input type="number" name="stok" class="w-full border rounded px-3 py-2" placeholder="Jumlah Stok" required>
    </div>
    <div class="mb-4">
        <label class="block mb-1 font-medium">Gambar Produk</label>
        <input type="file" name="gambar" class="w-full border rounded px-3 py-2">
    </div>
    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
</form>
@endsection
