<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Supplier</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#f97316',
                        'primary-dark': '#ea580c',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 font-inter min-h-screen flex">

    <!-- Sidebar Vertikal -->
<aside class="w-64 bg-white shadow-lg flex flex-col border-r">

    <!-- Logo -->
    <div class="p-6 text-2xl font-bold text-orange-500 border-b">
        Grosir<span class="text-gray-800">Hub</span>
    </div>

    <!-- MAIN MENU -->
    <div class="px-4 mt-6">
        <p class="text-xs font-semibold text-gray-400 uppercase mb-3">
            Menu Utama
        </p>

        <nav class="space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('supplier.dashboard') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg transition
            {{ request()->routeIs('supplier.dashboard') ? 'bg-orange-100 text-orange-600 border-l-4 border-orange-500' : 'text-gray-700 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 10.5L12 3l9 7.5M5 10v10h5v-6h4v6h5V10"/>
                </svg>
                Dashboard
            </a>

            <!-- Produk -->
            <a href="{{ route('supplier.produk.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg transition
            {{ request()->routeIs('supplier.produk.*') ? 'bg-orange-100 text-orange-600 border-l-4 border-orange-500' : 'text-gray-700 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                    <path d="M3.3 7L12 12l8.7-5M12 22V12"/>
                </svg>
                Produk
            </a>

            <!-- Pesanan -->
            <a href="{{ route('supplier.pesanan.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg transition
            {{ request()->routeIs('supplier.pesanan.*') ? 'bg-orange-100 text-orange-600 border-l-4 border-orange-500' : 'text-gray-700 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path d="M6 2h12v20l-3-2-3 2-3-2-3 2V2z"/>
                    <path d="M9 6h6M9 10h6M9 14h4"/>
                </svg>
                Pesanan
            </a>
        </nav>

        <!-- PEMBATAS -->
        <div class="my-6 border-t"></div>

        <!-- PENGATURAN -->
        <p class="text-xs font-semibold text-gray-400 uppercase mt-8 mb-3">
            Pengaturan
        </p>

        <nav class="space-y-1">
            <a href="{{ route('supplier.profil.edit') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 12a5 5 0 100-10 5 5 0 000 10z"/>
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 20c0-4 4-6 8-6s8 2 8 6"/>
            </svg>
            Profil
            </a>

            <a href="{{ route('supplier.pengaturan') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.591 1.066
                        1.724 1.724 0 012.356 2.356 1.724 1.724 0 001.066 2.591c1.756.426 1.756 2.924 0 3.35
                        a1.724 1.724 0 00-1.066 2.591 1.724 1.724 0 01-2.356 2.356
                        1.724 1.724 0 00-2.591 1.066c-.426 1.756-2.924 1.756-3.35 0
                        a1.724 1.724 0 00-2.591-1.066 1.724 1.724 0 01-2.356-2.356
                        1.724 1.724 0 00-1.066-2.591c-1.756-.426-1.756-2.924 0-3.35
                        a1.724 1.724 0 001.066-2.591 1.724 1.724 0 012.356-2.356
                        1.724 1.724 0 002.591-1.066z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Pengaturan
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-red-500 hover:bg-red-50 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 12H9m0 0l3-3m-3 3l3 3" />
                    </svg>
                    Logout
                </button>
            </form>
        </nav>
    </div>
</aside>

    <!-- Konten Utama -->
    <main class="flex-1 p-6 max-w-7xl mx-auto space-y-6">

        <!-- Header atas sebelum hero card -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
            <!-- Sapaan -->
            <div class="text-gray-800 font-semibold text-lg">
                Hi, {{ Auth::user()->name }}
            </div>

            <!-- Search Produk -->
            <form action="{{ route('supplier.produk.index') }}" method="GET" class="flex-1 max-w-md">
                <div class="relative flex items-center">
                    <svg class="w-5 h-5 absolute left-3 text-gray-400" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35m0 0a7 7 0 10-9.9-9.9 7 7 0 009.9 9.9z"/>
                    </svg>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari produk..."
                        class="w-full pl-10 p-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-400 focus:outline-none"
                    >
                </div>
            </form>

            <!-- Ikon Pesan, Notifikasi, Pengaturan dengan warna -->
            <div class="flex items-center gap-3">
                <button class="p-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600">
                    <!-- Pesan Icon -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" 
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8s-9-3.582-9-8 4.03-8 9-8 9 3.582 9 8z"></path>
                    </svg>
                </button>
                <button class="p-2 rounded-lg bg-yellow-400 text-white hover:bg-yellow-500">
                    <!-- Notifikasi Icon -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" 
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </button>
            </div>
        </div>

    {{-- Konten Utama --}}
    <div class="flex-1 p-4">
        {{-- Slider Utama --}}
        <div class="mb-8 relative w-full h-52 rounded-2xl overflow-hidden" style="background-color:#f97316;">
            <div class="p-6 flex justify-between items-center h-full">
                <div>
                    <h2 class="text-2xl font-semibold mb-1 text-white">Selamat Datang, Supplier!</h2>
                    <p class="text-white/90 mb-4">Pantau terus produkmu dan kelola stok dengan mudah.</p>

                    {{-- Tombol Tambah Produk --}}
                    <a href="{{ route('supplier.produk.create') }}" 
                       class="inline-block bg-white text-orange-600 font-semibold px-4 py-2 rounded-md shadow hover:bg-gray-100">
                       + Tambah Produk
                    </a>
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

