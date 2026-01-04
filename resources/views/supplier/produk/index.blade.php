@extends('layouts.admin')

@section('title', 'Produk')
@section('header', 'Daftar Produk')

@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('supplier.produk.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Tambah Produk</a>
</div>

<table class="w-full bg-white rounded-lg shadow overflow-hidden">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3 text-left">#</th>
            <th class="p-3 text-left">Nama Produk</th>
            <th class="p-3 text-left">Harga</th>
            <th class="p-3 text-left">Stok</th>
            <th class="p-3 text-left">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php
            $produks = [
                ['id'=>1,'nama'=>'Produk A','harga'=>15000,'stok'=>10],
                ['id'=>2,'nama'=>'Produk B','harga'=>25000,'stok'=>5],
                ['id'=>3,'nama'=>'Produk C','harga'=>5000,'stok'=>20],
            ];
        @endphp
        @foreach($produks as $produk)
        <tr class="border-t">
            <td class="p-3">{{ $loop->iteration }}</td>
            <td class="p-3">{{ $produk['nama'] }}</td>
            <td class="p-3">Rp {{ number_format($produk['harga'],0,',','.') }}</td>
            <td class="p-3">{{ $produk['stok'] }}</td>
            <td class="p-3">
                <a href="{{ route('supplier.produk.edit', $produk['id']) }}" class="text-blue-500 hover:underline mr-2">Edit</a>
                <button class="text-red-500 hover:underline" onclick="alert('Produk dihapus!')">Hapus</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
