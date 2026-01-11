@extends('layouts.admin')

@section('title', 'Tambah Produk')
@section('header', 'Tambah Produk Baru')

@section('content')
<div class="bg-white p-6 rounded-lg shadow max-w-2xl">
    @if ($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('supplier.produk.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block mb-1 font-medium text-gray-700">Nama Produk <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="Nama Produk" required>
            </div>
            
            <div>
                <label class="block mb-1 font-medium text-gray-700">Kategori</label>
                <select name="category_id" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Harga <span class="text-red-500">*</span></label>
                    <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="0.00" required>
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock') }}" min="0" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="0" required>
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Min. Pembelian <span class="text-red-500">*</span></label>
                    <input type="number" name="min_order" value="{{ old('min_order', 1) }}" min="1" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="1" required>
                    <p class="text-xs text-gray-500 mt-1">Jumlah minimal pembelian</p>
                </div>
            </div>
            
            <div>
                <label class="block mb-1 font-medium text-gray-700">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <!-- Image Upload Section -->
            <div>
                <label class="block mb-2 font-medium text-gray-700">Foto Produk</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-orange-500 transition" id="imageDropZone">
                    <div class="flex flex-col items-center">
                        <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <p class="text-sm text-gray-600 mb-2">Klik atau drag foto di sini</p>
                        <p class="text-xs text-gray-500">JPG, PNG, GIF, WebP (Max 5MB)</p>
                    </div>
                    <input type="file" name="image" id="imageInput" accept="image/jpeg,image/png,image/gif,image/webp" class="hidden">
                </div>
                <div id="imagePreview" class="mt-3"></div>
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('supplier.produk.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg shadow">
                Simpan
            </button>
        </div>
    </form>
</div>

<script>
// Image upload with preview
const imageDropZone = document.getElementById('imageDropZone');
const imageInput = document.getElementById('imageInput');
const imagePreview = document.getElementById('imagePreview');

// Click to upload
imageDropZone.addEventListener('click', () => imageInput.click());

// File selection
imageInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) {
        showImagePreview(file);
    }
});

// Drag and drop
imageDropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    imageDropZone.classList.add('border-orange-500', 'bg-orange-50');
});

imageDropZone.addEventListener('dragleave', () => {
    imageDropZone.classList.remove('border-orange-500', 'bg-orange-50');
});

imageDropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    imageDropZone.classList.remove('border-orange-500', 'bg-orange-50');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        const file = files[0];
        if (file.type.startsWith('image/')) {
            imageInput.files = files;
            showImagePreview(file);
        } else {
            alert('Hanya file gambar yang diizinkan');
        }
    }
});

function showImagePreview(file) {
    const reader = new FileReader();
    reader.onload = (e) => {
        imagePreview.innerHTML = `
            <div class="mt-3">
                <img src="${e.target.result}" alt="Preview" class="w-32 h-32 object-cover rounded border">
                <p class="text-sm text-green-600 mt-1">✓ Foto siap diupload</p>
            </div>
        `;
    };
    reader.readAsDataURL(file);
}
</script>
@endsection