<form action="{{ route('supplier.profil.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label class="block text-gray-700">Foto Profil</label>
        <input type="file" name="foto" class="border p-2 rounded w-full">
    </div>

    <div class="mb-4">
        <label class="block text-gray-700">Nama</label>
        <input type="text" name="name" value="{{ Auth::user()->name }}" class="border p-2 rounded w-full">
    </div>

    <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">
        Simpan
    </button>
</form>
