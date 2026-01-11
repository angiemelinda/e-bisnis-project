@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')
@section('header', 'Manajemen Pengguna')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">Daftar Pengguna</h2>
        <a href="{{ route('superadmin.users.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
            <i class="fas fa-plus mr-2"></i>Tambah Pengguna
        </a>
    </div>

    <!-- Search and Filter -->
    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
        <form action="{{ route('superadmin.users') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" 
                       placeholder="Cari pengguna..." 
                       value="{{ request('search') }}"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="w-full md:w-48">
                <select name="role" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Role</option>
                    <option value="supplier" {{ request('role') == 'supplier' ? 'selected' : '' }}>Supplier</option>
                    <option value="dropshipper" {{ request('role') == 'dropshipper' ? 'selected' : '' }}>Dropshipper</option>
                    <option value="super_admin" {{ request('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    <option value="admin_produk" {{ request('role') == 'admin_produk' ? 'selected' : '' }}>Admin Produk</option>
                    <option value="admin_pengguna" {{ request('role') == 'admin_pengguna' ? 'selected' : '' }}>Admin Pengguna</option>
                    <option value="admin_transaksi" {{ request('role') == 'admin_transaksi' ? 'selected' : '' }}>Admin Transaksi</option>
                    <option value="admin_laporan" {{ request('role') == 'admin_laporan' ? 'selected' : '' }}>Admin Laporan</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
            <a href="{{ route('superadmin.users') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                <i class="fas fa-sync-alt mr-2"></i>Reset
            </a>
        </form>
    </div>

    <!-- Users Table -->
    <div class="overflow-x-auto bg-white rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" 
                                     src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF' }}" 
                                     alt="{{ $user->name }}">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                <div class="text-sm text-gray-500">ID: {{ $user->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $user->email }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $roleColors = [
                                'super_admin' => 'bg-red-100 text-red-800',
                                'admin_produk' => 'bg-purple-100 text-purple-800',
                                'admin_pengguna' => 'bg-indigo-100 text-indigo-800',
                                'admin_transaksi' => 'bg-blue-100 text-blue-800',
                                'admin_laporan' => 'bg-cyan-100 text-cyan-800',
                                'supplier' => 'bg-green-100 text-green-800',
                                'dropshipper' => 'bg-yellow-100 text-yellow-800',
                            ][$user->role] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $roleColors }}">
                            {{ str_replace('_', ' ', ucfirst($user->role)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('superadmin.users.edit', $user->id) }}" 
                           class="text-blue-600 hover:text-blue-900 mr-3"
                           title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('superadmin.users.destroy', $user->id) }}" 
                              method="POST" 
                              class="inline"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                        Tidak ada data pengguna yang ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->withQueryString()->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add any JavaScript needed for the users page
    document.addEventListener('DOMContentLoaded', function() {
        // Add your JavaScript here
    });
</script>
@endpush
