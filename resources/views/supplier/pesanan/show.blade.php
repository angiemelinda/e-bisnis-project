@extends('layouts.admin')

@section('title', 'Detail Pesanan')
@section('header', 'Detail Pesanan')

@section('content')
@php
    // Dummy data pesanan
    $pesanan = [
        'kode'=>'ORD-1001',
        'pembeli'=>'CV Maju',
        'alamat'=>'Jl. Sudirman No.12, Yogyakarta',
        'total'=>125000,
        'status'=>'Baru',
        'produk'=>[
            ['nama'=>'Produk A','qty'=>2,'harga'=>15000],
            ['nama'=>'Produk B','qty'=>5,'harga'=>17000],
        ]
    ];
@endphp

<div class="bg-white p-6 rounded-lg shadow max-w-3xl">
    <h3 class="text-lg font-semibold mb-4">Informasi Pesanan</h3>
    <p><strong>Kode Pesanan:</strong> {{ $pesanan['kode'] }}</p>
    <p><strong>Pembeli:</strong> {{ $pesanan['pembeli'] }}</p>
    <p><strong>Alamat:</strong> {{ $pesanan['alamat'] }}</p>
    <p><strong>Status:</strong> 
        @if($pesanan['status']=='Baru')
            <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded">{{ $pesanan['status'] }}</span>
        @elseif($pesanan['status']=='Proses')
            <span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded">{{ $pesanan['status'] }}</span>
        @else
            <span class="px-2 py-1 bg-green-100 text-green-600 rounded">{{ $pesanan['status'] }}</span>
        @endif
    </p>

    <h3 class="text-lg font-semibold mt-6 mb-2">Produk</h3>
    <table class="w-full border rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left">Nama Produk</th>
                <th class="p-2 text-left">Qty</th>
                <th class="p-2 text-left">Harga</th>
                <th class="p-2 text-left">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanan['produk'] as $item)
            <tr class="border-t">
                <td class="p-2">{{ $item['nama'] }}</td>
                <td class="p-2">{{ $item['qty'] }}</td>
                <td class="p-2">Rp {{ number_format($item['harga'],0,',','.') }}</td>
                <td class="p-2">Rp {{ number_format($item['qty'] * $item['harga'],0,',','.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="mt-4 font-bold text-right">Total: Rp {{ number_format($pesanan['total'],0,',','.') }}</p>

    <div class="mt-6 flex space-x-4">
        <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded" onclick="alert('Status diubah menjadi Proses!')">Proses Pesanan</button>
        <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded" onclick="alert('Pesanan selesai!')">Selesai</button>
    </div>
</div>
@endsection
