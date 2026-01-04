@extends('layouts.admin')

@section('title', 'Edit Produk')
@section('header', 'Edit Produk')

@section('content')
@php
    // Dummy data produk
    $produk = ['id'=>1,'nama'=>'Produk A','harga'=>15000,'stok'=>10,'gambar'=>''];
@endphp

<form class="bg-white p-6 rounded-lg shadow max-w-lg" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-4">
        <label class="block mb-1 font-medium">Nama Produk</label>
        <input type="text" name="nama" class="w-full border rounded px-3 py-2" value="{{ $produk['nama'] }}" required>
    </div>
    <div class="mb-4">
        <label class="block mb-1 font-medium">Harga</label>
        <input type="number" name="harga" class="w-full border rounded px-3 py-2" value="{{ $produk['harga'] }}" required>
    </div>
    <div class="mb-4">
        <label class="block mb-1 font-medium">Stok</label>
        <input type="number" name="stok" class="w-full border rounded px-3 py-2" value="{{ $produk['stok'] }}" required>
    </div>
    <div class="mb-4">
        <label class="block mb-1 font-medium">Gambar Produk</label>
        <input type="file" name="gambar" class="w-full border rounded px-3 py-2">
        @if($produk['gambar'])
            <img src="{{ $produk['gambar'] }}" class="mt-2 w-32">
        @endif
    </div>
    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">Update</button>
</form>
@endsection
