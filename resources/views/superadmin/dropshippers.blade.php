@extends('layouts.superadmin')

@section('title', 'Daftar Dropshipper')
@section('header', 'Dropshipper')

@section('content')
<!-- Tombol Tambah Dropshipper -->
<div class="flex justify-end mb-4">
    <a href="{{ route('superadmin.dropshippers.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded shadow">Tambah Dropshipper</a>
</div>

<!-- Tabel Dropshipper -->
<div class="bg-white shadow rounded-lg p-5 overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-orange-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Total Pesanan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($dropshippers as $dropshipper)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $dropshipper->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $dropshipper->email }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    @if($dropshipper->is_active)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Nonaktif</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $dropshipper->orders_count ?? 0 }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <a href="{{ route('superadmin.dropshippers.edit', $dropshipper->id) }}" class="text-blue-500 hover:underline mr-2">Edit</a>
                    <form action="{{ route('superadmin.dropshippers.destroy', $dropshipper->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus dropshipper ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $dropshippers->links() }}
</div>
@endsection
