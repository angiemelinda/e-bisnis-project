@extends('layouts.superadmin')

@section('title', 'Manajemen Pengguna')
@section('header', 'Pengguna')

@section('content')
<!-- Tombol Tambah Pengguna -->
<div class="flex justify-end mb-4">
    <a href="{{ route('users.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded shadow">Tambah Pengguna</a>
</div>

<!-- Tabel Pengguna -->
<div class="bg-white shadow rounded-lg p-5 overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-orange-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Role</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($users as $user)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $user->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $user->email }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ ucfirst($user->role) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    @if($user->is_active)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Nonaktif</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <a href="{{ route('users.edit', $user->id) }}" class="text-blue-500 hover:underline mr-2">Edit</a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus pengguna ini?')">
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

<!-- Pagination (opsional) -->
<div class="mt-4">
    {{ $users->links() }}
</div>
@endsection
