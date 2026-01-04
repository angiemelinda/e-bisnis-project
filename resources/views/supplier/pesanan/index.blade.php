@extends('layouts.admin')

@section('title', 'Pesanan')
@section('header', 'Daftar Pesanan')

@section('content')
<table class="w-full bg-white rounded-lg shadow overflow-hidden">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3 text-left">#</th>
            <th class="p-3 text-left">Kode Pesanan</th>
            <th class="p-3 text-left">Nama Pembeli</th>
            <th class="p-3 text-left">Total</th>
            <th class="p-3 text-left">Status</th>
            <th class="p-3 text-left">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php
            $pesanans = [
                ['id'=>1,'kode'=>'ORD-1001','pembeli'=>'CV Maju','total'=>125000,'status'=>'Baru'],
                ['id'=>2,'kode'=>'ORD-1002','pembeli'=>'UD Sejahtera','total'=>85000,'status'=>'Proses'],
                ['id'=>3,'kode'=>'ORD-1003','pembeli'=>'PT Sukses','total'=>220000,'status'=>'Selesai'],
            ];
        @endphp
        @foreach($pesanans as $pesanan)
        <tr class="border-t">
            <td class="p-3">{{ $loop->iteration }}</td>
            <td class="p-3">{{ $pesanan['kode'] }}</td>
            <td class="p-3">{{ $pesanan['pembeli'] }}</td>
            <td class="p-3">Rp {{ number_format($pesanan['total'],0,',','.') }}</td>
            <td class="p-3">
                @if($pesanan['status']=='Baru')
                    <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded">{{ $pesanan['status'] }}</span>
                @elseif($pesanan['status']=='Proses')
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded">{{ $pesanan['status'] }}</span>
                @else
                    <span class="px-2 py-1 bg-green-100 text-green-600 rounded">{{ $pesanan['status'] }}</span>
                @endif
            </td>
            <td class="p-3">
                <a href="{{ route('supplier.pesanan.show', $pesanan['id']) }}" class="text-blue-500 hover:underline">Detail</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
