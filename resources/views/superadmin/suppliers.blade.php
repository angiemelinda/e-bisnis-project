@extends('layouts.superadmin')

@section('title', 'Supplier')
@section('header', 'Supplier')

@section('content')
<!-- Tombol Tambah Supplier -->
<div class="flex justify-end mb-4">
    <a href="#" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded shadow">Tambah Supplier</a>
</div>

<!-- Tabel Supplier -->
<div class="bg-white shadow rounded-lg p-5 overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-orange-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Nama Supplier</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Telepon</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @php
                $suppliers = [
                    ['name'=>'Supplier 1','email'=>'supplier1@example.com','phone'=>'08123456789','is_active'=>true],
                    ['name'=>'Supplier 2','email'=>'supplier2@example.com','phone'=>'08198765432','is_active'=>false],
                    ['name'=>'Supplier 3','email'=>'supplier3@example.com','phone'=>'08111222333','is_active'=>true],
                ];
            @endphp

            @foreach($suppliers as $supplier)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $supplier['name'] }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $supplier['email'] }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $supplier['phone'] }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    @if($supplier['is_active'])
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded">Aktif</span>
                    @else
                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded">Nonaktif</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <a href="#" class="text-blue-500 hover:underline mr-2">Edit</a>
                    <a href="#" class="text-red-500 hover:underline">Hapus</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pagination Dummy -->
<div class="mt-4 flex justify-center">
    <nav class="inline-flex -space-x-px">
        <a href="#" class="px-3 py-1 bg-white border border-gray-300 rounded-l hover:bg-orange-50">Previous</a>
        <a href="#" class="px-3 py-1 bg-orange-100 border border-gray-300 hover:bg-orange-200">1</a>
        <a href="#" class="px-3 py-1 bg-white border border-gray-300 hover:bg-orange-50">2</a>
        <a href="#" class="px-3 py-1 bg-white border border-gray-300 rounded-r hover:bg-orange-50">Next</a>
    </nav>
</div>
@endsection
