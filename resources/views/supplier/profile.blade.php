@extends('layouts.admin')

@section('title', 'Profil Supplier')
@section('header', 'Profil Saya')

@section('content')
@php
    // Dummy data supplier
    $supplier = [
        'nama' => 'CV Maju Jaya',
        'email' => 'supplier@mail.com',
        'telepon' => '08123456789',
        'alamat' => 'Jl. Sudirman No.12, Yogyakarta',
        'logo' => '' // bisa diisi path gambar
    ];
@endphp

<div class="bg-white p-6 rounded-lg shadow max-w-3xl mx-auto">
    <h3 class="text-lg font-semibold mb-4">Informasi Akun</h3>

    <form method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-medium">Nama Supplier</label>
            <input type="text" name="nama" class="w-full border rounded px-3 py-2" value="{{ $supplier['nama'] }}" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Email</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2" value="{{ $supplier['email'] }}" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Telepon</label>
            <input type="text" name="telepon" class="w-full border rounded px-3 py-2" value="{{ $supplier['telepon'] }}" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Alamat</label>
            <textarea name="alamat" class="w-full border rounded px-3 py-2" rows="3" required>{{ $supplier['alamat'] }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Logo Supplier</label>
            <input type="file" name="logo" class="w-full border rounded px-3 py-2">
            @if($supplier['logo'])
                <img src="{{ $supplier['logo'] }}" class="mt-2 w-32 h-32 object-cover rounded">
            @endif
        </div>

        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Simpan Perubahan</button>
    </form>

    <hr class="my-6">

    <h3 class="text-lg font-semibold mb-4">Ubah Password</h3>
    <form method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-medium">Password Baru</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2" placeholder="Password baru">
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2" placeholder="Konfirmasi password">
        </div>
        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">Ubah Password</button>
    </form>
</div>
@endsection
