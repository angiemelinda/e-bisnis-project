@extends('layouts.profil.supplier-modern')

@section('title', 'Edit Profil')

@section('content')
<div class="bg-white rounded-2xl shadow-lg overflow-hidden max-w-6xl mx-auto">

    <form action="{{ route('supplier.profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-4">

            <!-- LEFT : PROFILE SUMMARY -->
            <div class="bg-gray-50 p-5 flex flex-col items-center text-center border-r md:col-span-1">

                <!-- WRAPPER ISI (DITURUNKAN) -->
                <div class="mt-12 flex flex-col items-center">

                    <div class="w-28 h-28 rounded-full bg-orange-100 text-orange-600
                                flex items-center justify-center text-4xl font-bold mb-4">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    <h3 class="text-lg font-semibold text-gray-800">
                        {{ auth()->user()->name }}
                    </h3>

                    <p class="text-sm text-gray-500 mb-5">
                        Supplier GrosirHub
                    </p>

                    <label class="cursor-pointer text-sm font-medium
                                bg-orange-500 text-white px-4 py-2 rounded-lg
                                hover:bg-orange-600 transition">
                        Ganti Foto
                        <input type="file" name="avatar" class="hidden">
                    </label>

                </div>

            </div>

            <!-- RIGHT : FORM -->
            <div class="md:col-span-3 p-10">

                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-800">
                        Informasi Akun
                    </h4>
                    <p class="text-sm text-gray-500 mt-1">
                        Kelola dan perbarui informasi akun serta data pribadi Anda.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="text-sm text-gray-500">Username</label>
                        <input type="text" name="username" value="{{ auth()->user()->username }}"
                            class="w-full mt-1 border rounded-lg p-2 focus:ring-2 focus:ring-orange-400">
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">Email</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}"
                            class="w-full mt-1 border rounded-lg p-2 focus:ring-2 focus:ring-orange-400">
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ auth()->user()->name }}"
                            class="w-full mt-1 border rounded-lg p-2 focus:ring-2 focus:ring-orange-400">
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">No. Telepon</label>
                        <input type="text" name="phone" value="{{ auth()->user()->phone }}"
                            class="w-full mt-1 border rounded-lg p-2 focus:ring-2 focus:ring-orange-400">
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">Nama Toko</label>
                        <input type="text" name="nama_toko" value="{{ auth()->user()->nama_toko }}"
                            class="w-full mt-1 border rounded-lg p-2 focus:ring-2 focus:ring-orange-400">
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">Jenis Kelamin</label>
                        <select name="jenis_kelamin"
                            class="w-full mt-1 border rounded-lg p-2 focus:ring-2 focus:ring-orange-400">
                            <option value="L" {{ auth()->user()->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ auth()->user()->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir"
                            value="{{ auth()->user()->tanggal_lahir }}"
                            class="w-full mt-1 border rounded-lg p-2 focus:ring-2 focus:ring-orange-400">
                    </div>

                </div>

                <!-- ACTION -->
                <div class="mt-8 flex gap-4">
                    <button type="submit"
                        class="px-6 py-2 bg-orange-500 hover:bg-orange-600
                               text-white rounded-lg font-medium transition">
                        Simpan Profil
                    </button>

                    <a href="{{ route('supplier.password.change') }}"
                        class="px-6 py-2 bg-gray-200 hover:bg-gray-300
                               rounded-lg font-medium transition">
                        Ganti Password
                    </a>
                </div>

            </div>

        </div>
    </form>
</div>
@endsection