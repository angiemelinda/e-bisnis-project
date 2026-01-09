@extends('layouts.profil.supplier-modern')

@section('title', 'Profil Supplier')

@section('header', 'Profil Supplier')

@section('content')

<!-- Card Profil -->
<div class="bg-white p-8 rounded-2xl shadow-sm border">

    <p class="text-gray-500 mb-6">
        Kelola data akun dan informasi toko Anda
    </p>

    <!-- Tombol Aksi -->
    <div class="flex flex-wrap gap-4">
        <a href="{{ route('supplier.profil.edit') }}" 
           class="px-6 py-2.5 bg-sky-500 hover:bg-blue-600
                  text-white rounded-xl font-semibold transition shadow">
            Edit Profil
        </a>

        <a href="{{ route('supplier.password.change') }}" 
           class="px-6 py-2.5 bg-yellow-400 hover:bg-yellow-500
                  text-white rounded-xl font-semibold transition shadow">
            Ubah Password
        </a>
    </div>

</div>

@endsection