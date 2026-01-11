@extends('layouts.supplier')

@section('title', 'Produk')
@section('header', 'Produk')

@section('content')

    {{-- Konten Utama --}}
    <div class="flex-1 p-4">
        {{-- Slider Utama --}}
        <div class="mb-8 relative w-full h-52 rounded-2xl overflow-hidden" style="background-color:#f97316;">
            <div class="p-6 flex justify-between items-center h-full">
                <div>
                    <h2 class="text-2xl font-semibold mb-1 text-white">Selamat Datang, Supplier!</h2>
                    <p class="text-white/90 mb-4">Pantau terus produkmu dan kelola stok dengan mudah.</p>

                    {{-- Tombol Tambah Produk --}}
                    <button onclick="openAddProductModal()" 
                       class="inline-block bg-white text-orange-600 font-semibold px-4 py-2 rounded-md shadow hover:bg-gray-100">
                       + Tambah Produk
                    </button>
                </div>
                <div class="h-full flex items-center">
                    <img src="/path/to/supplier-promo.png" class="h-40 object-cover rounded-lg">
                </div>
            </div>
        </div>

        {{-- Kategori Produk --}}
        @if(isset($categories) && $categories->count() > 0)
        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-3">Kategori Produk</h3>
            <div class="flex flex-wrap gap-4">
                @foreach($categories as $kategori)
                <div class="shadow hover:shadow-md rounded-md px-4 py-4 cursor-pointer text-center w-32 bg-blue-100">
                    <div class="h-14 w-14 mx-auto mb-2 flex items-center justify-center rounded-full overflow-hidden bg-white text-xl">
                        📦
                    </div>
                    <span class="text-gray-700 font-semibold text-sm">{{ $kategori->name }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Produk Saya --}}
        @if(isset($produks) && $produks->count() > 0)
        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-3">Produk Saya</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($produks as $produk)
                <div class="bg-white rounded-lg shadow hover:shadow-lg p-4 flex flex-col relative">
                    {{-- Status Badge --}}
                    <div class="absolute top-2 right-2 text-xs font-bold px-2 py-1 rounded {{ $produk->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $produk->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                    </div>

                    {{-- Gambar Produk --}}
                    <div class="h-40 bg-gray-100 mb-4 rounded-lg flex items-center justify-center overflow-hidden">
                        @if($produk->primaryImage)
                            <img src="{{ $produk->image_url }}" alt="{{ $produk->name }}" class="h-full w-full object-cover">
                        @else
                            <span class="text-gray-400">📷 Belum ada gambar</span>
                        @endif
                    </div>
                    
                    <h4 class="font-semibold text-lg mb-1 line-clamp-2">{{ $produk->name }}</h4>
                    
                    {{-- Kategori --}}
                    @if($produk->category)
                    <p class="text-xs text-gray-500 mb-2">{{ $produk->category->name }}</p>
                    @endif
                    
                    {{-- Harga --}}
                    <p class="text-gray-600 mb-2 font-semibold">
                        Rp {{ number_format($produk->price, 0, ',', '.') }}
                    </p>
                    
                    {{-- Stok --}}
                    <p class="mb-3">
                        @if($produk->stock > 0)
                            <span class="text-green-600 font-medium text-sm">📦 Stok: {{ $produk->stock }}</span>
                        @else
                            <span class="text-red-600 font-medium text-sm">❌ Stok Habis</span>
                        @endif
                    </p>
                    
                    {{-- Action Buttons --}}
                    <div class="flex gap-2 mt-auto text-xs">
                        <a href="{{ route('supplier.produk.edit', $produk->id) }}" class="flex-1 text-center bg-yellow-400 hover:bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                        <form action="{{ route('supplier.produk.destroy', $produk->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded">Hapus</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="mb-8 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-4 rounded">
            <p class="font-semibold">📭 Belum ada produk</p>
            <p class="text-sm">Klik tombol "+ Tambah Produk" di atas untuk menambahkan produk baru.</p>
        </div>
        @endif

    </div>
</div>

<!-- Modal Tambah Produk -->
<div id="addProductModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full mx-4 max-h-[90vh] overflow-y-auto">
        <!-- Header Modal -->
        <div class="sticky top-0 bg-gradient-to-r from-orange-500 to-orange-600 text-white p-6 border-b">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">Tambah Produk Baru</h2>
                <button onclick="closeAddProductModal()" class="text-white hover:text-gray-200 text-2xl leading-none">&times;</button>
            </div>
        </div>

        <!-- Form Content -->
        <form id="addProductForm" class="p-6 space-y-4">
            @csrf

            <!-- Success Message -->
            <div id="successMessage" class="hidden bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span>Produk berhasil ditambahkan!</span>
            </div>

            <!-- Error Messages -->
            <div id="errorMessages" class="hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded"></div>

            <!-- Nama Produk -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">Nama Produk <span class="text-red-500">*</span></label>
                <input type="text" name="name" placeholder="Nama Produk" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-transparent" required>
            </div>

            <!-- Kategori -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">Kategori</label>
                <select name="category_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="">Pilih Kategori</option>
                    @if(isset($categories))
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <!-- Harga & Stok -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Harga <span class="text-red-500">*</span></label>
                    <input type="number" name="price" step="0.01" min="0" placeholder="0.00" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-transparent" required>
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" min="0" placeholder="0" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-transparent" required>
                </div>
            </div>

            <!-- Status -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="active" selected>Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>
            </div>

            <!-- Gambar Produk -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">Gambar Produk</label>
                <div class="relative">
                    <input type="file" id="productImage" name="image" accept="image/*" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-transparent cursor-pointer">
                    <small class="text-gray-500 block mt-1">Format: JPG, PNG, GIF (Max 5MB)</small>
                </div>
                <!-- Image Preview -->
                <div id="imagePreview" class="mt-2 hidden">
                    <p class="text-sm text-gray-600 mb-2">Preview Gambar:</p>
                    <img id="previewImg" src="" alt="Preview" class="w-24 h-24 object-cover rounded border border-gray-300">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 pt-4 border-t">
                <button type="button" onclick="closeAddProductModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                    Batal
                </button>
                <button type="submit" id="submitBtn" class="flex-1 px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-medium">
                    Simpan
                </button>
            </div>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript untuk Modal -->
<script type="text/javascript">
// Image preview handler
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('productImage');
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = this.files[0];
            const previewDiv = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            
            if (file) {
                // Validate file type
                const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    alert('Format file harus JPG, PNG, GIF, atau WebP');
                    this.value = '';
                    previewDiv.classList.add('hidden');
                    return;
                }
                
                // Validate file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('Ukuran file maksimal 5MB');
                    this.value = '';
                    previewDiv.classList.add('hidden');
                    return;
                }
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewDiv.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                previewDiv.classList.add('hidden');
                previewImg.src = '';
            }
        });
    }
});

function openAddProductModal() {
    console.log('Opening modal...');
    const modal = document.getElementById('addProductModal');
    console.log('Modal element:', modal);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        console.log('Modal opened');
    } else {
        console.error('Modal element not found!');
    }
}

function closeAddProductModal() {
    document.getElementById('addProductModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    document.getElementById('addProductForm').reset();
    document.getElementById('errorMessages').classList.add('hidden');
    document.getElementById('successMessage').classList.add('hidden');
    document.getElementById('imagePreview').classList.add('hidden');
}

// Close modal ketika klik di luar modal
document.getElementById('addProductModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAddProductModal();
    }
});

// Handle form submission dengan AJAX
document.getElementById('addProductForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    console.log('Form submitted');
    
    const submitBtn = document.getElementById('submitBtn');
    const errorDiv = document.getElementById('errorMessages');
    const successDiv = document.getElementById('successMessage');
    
    // Reset messages
    errorDiv.classList.add('hidden');
    successDiv.classList.add('hidden');
    
    // Disable submit button
    submitBtn.disabled = true;
    submitBtn.textContent = 'Menyimpan...';
    
    try {
        const formData = new FormData(this);
        console.log('Form data prepared, sending request...');
        
        const response = await fetch('{{ route("supplier.produk.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        const data = await response.json();
        console.log('Response data:', data);
        
        if (response.ok) {
            // Show success message
            console.log('Success! Showing success message');
            successDiv.classList.remove('hidden');
            
            // Reset form
            document.getElementById('addProductForm').reset();
            
            // Close modal setelah 2 detik
            setTimeout(() => {
                closeAddProductModal();
                // Reload halaman untuk menampilkan produk baru
                console.log('Reloading page...');
                location.reload();
            }, 1500);
        } else {
            // Show error messages
            console.log('Error response. Errors:', data.errors);
            if (data.errors) {
                let errorHtml = '<ul class="list-disc list-inside">';
                for (const [field, messages] of Object.entries(data.errors)) {
                    messages.forEach(msg => {
                        errorHtml += `<li>${msg}</li>`;
                    });
                }
                errorHtml += '</ul>';
                errorDiv.innerHTML = errorHtml;
            } else {
                errorDiv.textContent = data.message || 'Gagal menyimpan produk';
            }
            errorDiv.classList.remove('hidden');
        }
    } catch (error) {
        console.error('Error:', error);
        errorDiv.innerHTML = '<p>Terjadi kesalahan saat mengirim data. Silakan coba lagi.</p>';
        errorDiv.classList.remove('hidden');
    } finally {
        // Re-enable submit button
        submitBtn.disabled = false;
        submitBtn.textContent = 'Simpan';
    }
});
</script>

@endsection
