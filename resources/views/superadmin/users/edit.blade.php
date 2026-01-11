@extends('layouts.admin')

@section('title', 'Edit Pengguna')
@section('header', 'Edit Pengguna')

@section('content')
<div class="bg-white shadow rounded-lg p-6 max-w-2xl">
    @if ($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('superadmin.users.update', $user->id) }}">
        @csrf
        @method('PUT')
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5" for="name">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    placeholder="Nama lengkap"
                    required
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5" for="email">
                    Email <span class="text-red-500">*</span>
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    placeholder="nama@email.com"
                    required
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5" for="phone">
                    No. Telepon <span class="text-red-500">*</span>
                </label>
                <input 
                    type="tel" 
                    id="phone" 
                    name="phone"
                    value="{{ old('phone', $user->phone) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    placeholder="08xxxxxxxxxx"
                    required
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5" for="role">
                    Role <span class="text-red-500">*</span>
                </label>
                <select 
                    id="role" 
                    name="role"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    required
                >
                    <option value="">Pilih Role</option>
                    @foreach($roles as $key => $label)
                        <option value="{{ $key }}" {{ old('role', $user->role) == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5" for="password">
                    Password <span class="text-gray-400">(Kosongkan jika tidak ingin mengubah)</span>
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    placeholder="Minimal 8 karakter"
                >
                <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5" for="password_confirmation">
                    Konfirmasi Password
                </label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    placeholder="Konfirmasi password"
                >
            </div>

            <div>
                <label class="flex items-center cursor-pointer">
                    <input 
                        type="checkbox" 
                        id="is_active" 
                        name="is_active" 
                        value="1"
                        {{ old('is_active', $user->is_active ?? false) ? 'checked' : '' }}
                        class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500"
                    >
                    <span class="ml-2 text-sm text-gray-700">Aktifkan pengguna</span>
                </label>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('superadmin.users') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Batal
            </a>
            <button 
                type="submit"
                class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg shadow">
                Update
            </button>
        </div>
    </form>
</div>
@endsection



