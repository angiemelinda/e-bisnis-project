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
        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-3">Kategori Produk</h3>
            <div class="flex flex-wrap gap-4">
                @php
                    $kategoris = [
                        ['nama' => 'Fashion', 'icon' => '/images/fashion.png', 'warna' => 'bg-blue-200'],
                        ['nama' => 'Elektronik', 'icon' => '/images/elektronik.png', 'warna' => 'bg-gray-200'],
                        ['nama' => 'Kecantikan', 'icon' => '/images/kecantikan.png', 'warna' => 'bg-pink-200'],
                        ['nama' => 'Makanan', 'icon' => '/images/makanan.png', 'warna' => 'bg-green-200'],
                        ['nama' => 'Peralatan Rumah', 'icon' => '/images/peralatan.png', 'warna' => 'bg-yellow-200'],
                        ['nama' => 'Mainan', 'icon' => '/images/mainan.png', 'warna' => 'bg-red-200'],
                    ];
                @endphp

                @foreach($kategoris as $kategori)
                <div class="shadow hover:shadow-md rounded-md px-4 py-4 cursor-pointer text-center w-32 {{ $kategori['warna'] }}">
                    <div class="h-14 w-14 mx-auto mb-2 flex items-center justify-center rounded-full overflow-hidden bg-white">
                        <img src="{{ asset($kategori['icon']) }}" alt="{{ $kategori['nama'] }}" class="h-full w-full object-cover">
                    </div>
                    <span class="text-gray-700 font-semibold">{{ $kategori['nama'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Banner Promo Kecil --}}
        <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-yellow-50 rounded-lg p-4 flex items-center justify-between">
                <div>
                    <h4 class="font-semibold mb-1">Rekomendasi produk</h4>
                    <p class="text-gray-600 text-sm">Kualitas Terjamin</p>
                    <a href="#" class="mt-2 inline-block bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Lihat Produk</a>
                </div>
                <img src="/path/to/product1.png" class="h-16" alt="Produk 1">
            </div>
            <div class="bg-pink-50 rounded-lg p-4 flex items-center justify-between">
                <div>
                    <h4 class="font-semibold mb-1">Produk Populer</h4>
                    <p class="text-gray-600 text-sm">Paling Banyak Dibeli</p>
                    <a href="#" class="mt-2 inline-block bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Lihat Produk</a>
                </div>
                <img src="/path/to/product2.png" class="h-16" alt="Produk 2">
            </div>
            <div class="bg-blue-50 rounded-lg p-4 flex items-center justify-between">
                <div>
                    <h4 class="font-semibold mb-1">Produk Baru</h4>
                    <p class="text-gray-600 text-sm">Update Setiap Hari</p>
                    <a href="#" class="mt-2 inline-block bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Lihat Produk</a>
                </div>
                <img src="/path/to/product3.png" class="h-16" alt="Produk 3">
            </div>
        </div>

        {{-- Produk Terlaris🔥 --}}
        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-3">Produk Terlaris🔥 </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @php
                    $produks = [
                        ['id'=>1,'nama'=>'Produk A','harga'=>15000,'stok'=>10,'diskon'=>10,'rating'=>4],
                        ['id'=>2,'nama'=>'Produk B','harga'=>25000,'stok'=>0,'diskon'=>0,'rating'=>5],
                        ['id'=>3,'nama'=>'Produk C','harga'=>5000,'stok'=>20,'diskon'=>5,'rating'=>3],
                    ];
                @endphp
                @foreach($produks as $produk)
                <div class="bg-white rounded-lg shadow hover:shadow-lg p-4 flex flex-col relative">
                    {{-- Stempel Diskon --}}
                    @if($produk['diskon'] > 0)
                    <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">Diskon {{ $produk['diskon'] }}%</div>
                    @endif

                    {{-- Gambar Produk --}}
                    <div class="h-40 bg-gray-100 mb-4 rounded-lg flex items-center justify-center">
                        <span class="text-gray-400">Gambar Produk</span>
                    </div>
                    
                    <h4 class="font-semibold text-lg mb-1">{{ $produk['nama'] }}</h4>
                    
                    <div class="flex items-center mb-1">
                        @for($i=1;$i<=5;$i++)
                            @if($i <= $produk['rating'])
                                <span class="text-yellow-400">★</span>
                            @else
                                <span class="text-gray-300">★</span>
                            @endif
                        @endfor
                    </div>
                    
                    <p class="text-gray-600 mb-1">
                        Rp {{ number_format($produk['harga'],0,',','.') }}
                        @if($produk['diskon'] > 0)
                            <span class="text-green-500 font-medium ml-2">Diskon {{ $produk['diskon'] }}%</span>
                        @endif
                    </p>
                    
                    <p class="mb-2">
                        @if($produk['stok'] > 0)
                            <span class="text-green-500 font-medium">Stok: {{ $produk['stok'] }}</span>
                        @else
                            <span class="text-red-500 font-medium">Habis Stok</span>
                        @endif
                    </p>
                    
                    <div class="mt-auto flex gap-2">
                        <a href="{{ route('supplier.produk.edit', $produk['id']) }}" class="flex-1 text-center bg-yellow-400 hover:bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                        <button onclick="if(confirm('Apakah Anda yakin ingin menghapus produk ini?')){ alert('Produk dihapus!'); }" class="flex-1 text-center bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded">Hapus</button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

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
