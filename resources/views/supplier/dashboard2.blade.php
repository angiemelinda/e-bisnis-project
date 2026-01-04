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
            <a href="{{ route('supplier.profile') }}"
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

        <!-- Hero Card Lebar -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl p-8 text-white flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold mb-2">Selamat Datang, Supplier!</h1>
                <p class="text-sm text-orange-100">Pantau produk dan pesanan Anda dengan mudah di dashboard ini.</p>
            </div>
            <div class="hidden md:block w-32 h-32 bg-white/20 rounded-full"></div>
        </div>

        <!-- Ringkasan -->
<!-- Ringkasan -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

    <!-- Total Produk -->
    <div class="flex items-center gap-4 bg-white rounded-xl p-5 shadow hover:shadow-lg transition">
        <div class="bg-orange-500 text-white p-4 rounded-xl">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 7l9-4 9 4-9 4-9-4z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 17l9 4 9-4" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 12l9 4 9-4" />
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ $totalProduk }}</p>
            <p class="text-sm text-gray-500">Total Produk</p>
        </div>
    </div>

    <!-- Total Pesanan -->
    <div class="flex items-center gap-4 bg-orange-50 rounded-xl p-5 shadow hover:shadow-lg transition">
        <div class="bg-orange-600 text-white p-4 rounded-xl">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 3h18l-2 13H5L3 3z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16 16a2 2 0 11-4 0" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M8 16a2 2 0 11-4 0" />
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ $totalOrders }}</p>
            <p class="text-sm text-gray-600">Total Pesanan</p>
        </div>
    </div>

    <!-- Total Stok -->
    <div class="flex items-center gap-4 bg-white rounded-xl p-5 shadow hover:shadow-lg transition">
        <div class="bg-orange-500 text-white p-4 rounded-xl">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 6h16v12H4z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 10h16" />
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ $totalStok }}</p>
            <p class="text-sm text-gray-500">Total Stok</p>
        </div>
    </div>

    <!-- Stok Habis -->
    <div class="flex items-center gap-4 bg-orange-50 rounded-xl p-5 shadow hover:shadow-lg transition">
        <div class="bg-red-500 text-white p-4 rounded-xl">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v4m0 4h.01" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ $outOfStock }}</p>
            <p class="text-sm text-gray-600">Stok Habis</p>
        </div>
    </div>

</div>

            <!-- Pesanan Terbaru -->
<div class="bg-white rounded-xl shadow p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-900">Pesanan Terbaru</h2>
        <a href="{{ route('supplier.pesanan.index') }}" class="text-sm text-orange-500 hover:underline">
            Lihat Semua
        </a>
    </div>

    <div class="space-y-4">
        @foreach($pesananTerbaru as $pesanan)
        <div class="flex items-center justify-between p-4 border rounded-xl hover:shadow transition">
            
            <!-- Info Pesanan -->
            <div class="flex items-center gap-4">
                <div class="bg-orange-100 text-orange-600 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 3h18l-2 13H5L3 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 16a2 2 0 11-4 0" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 16a2 2 0 11-4 0" />
                    </svg>
                </div>

                <div>
                    <p class="font-semibold text-gray-800">
                        Pesanan #{{ $pesanan->id }}
                    </p>
                    <p class="text-sm text-gray-500">
                        Status: 
                        <span class="
                            @if($pesanan->status == 'belum diproses') text-yellow-600
                            @elseif($pesanan->status == 'sedang dikirim') text-blue-600
                            @else text-green-600 @endif
                        ">
                            {{ ucfirst($pesanan->status) }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- Aksi -->
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 text-xs rounded-full 
                    @if($pesanan->status == 'belum diproses') bg-yellow-100 text-yellow-700
                    @elseif($pesanan->status == 'sedang dikirim') bg-blue-100 text-blue-700
                    @else bg-green-100 text-green-700
                    @endif">
                    {{ ucfirst($pesanan->status) }}
                </span>

                <a href="{{ route('supplier.pesanan.show', $pesanan->id) }}"
                   class="text-sm text-orange-500 hover:underline font-medium">
                    Detail
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- PRODUK TERATAS & STOK MENIPIS -->
<div class="bg-white p-6 rounded-xl shadow space-y-4">
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-900">🔥 Produk Terlaris & Stok Rendah</h2>
        <a href="{{ route('supplier.produk.index') }}" class="text-sm text-orange-500 hover:underline">
            Kelola Produk
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        @foreach($produkTeratas as $produk)
        <div class="flex gap-4 bg-gray-50 rounded-xl p-4 hover:shadow transition">
            
            <!-- GAMBAR PRODUK -->
            <div class="w-20 h-20 rounded-lg overflow-hidden bg-gray-200 flex-shrink-0">
                <img 
                    src="{{ $produk->gambar ?? 'https://via.placeholder.com/150' }}" 
                    class="w-full h-full object-cover"
                    alt="{{ $produk->nama }}">
            </div>

            <!-- INFO PRODUK -->
            <div class="flex-1">
                <h3 class="font-semibold text-gray-900 leading-tight">
                    {{ $produk->nama }}
                </h3>

                <!-- Harga -->
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-sm text-gray-400 line-through">
                        Rp {{ number_format($produk->harga_asli ?? 0, 0, ',', '.') }}
                    </span>
                    <span class="text-orange-600 font-semibold">
                        Rp {{ number_format($produk->harga_jual ?? 0, 0, ',', '.') }}
                    </span>
                </div>

                <!-- Stok -->
                <div class="mt-2">
                    @if($produk->stok <= 3)
                        <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded-full">
                            ⚠ Stok hampir habis ({{ $produk->stok }})
                        </span>
                    @else
                        <span class="text-xs bg-green-100 text-green-600 px-2 py-1 rounded-full">
                            Stok tersedia ({{ $produk->stok }})
                        </span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>

<!-- Shortcut / Aksi Cepat -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-5">

    <!-- Tambah Produk -->
    <a href="{{ route('supplier.produk.create') }}"
       class="bg-white rounded-xl p-5 flex items-center gap-4 shadow hover:shadow-lg transition">
        <div class="bg-orange-100 text-orange-600 p-3 rounded-xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path d="M12 5v14M5 12h14"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold text-gray-900">Tambah Produk</p>
            <p class="text-sm text-gray-500">Upload produk baru</p>
        </div>
    </a>

    <!-- Pesanan -->
    <a href="{{ route('supplier.pesanan.index') }}"
       class="bg-white rounded-xl p-5 flex items-center gap-4 shadow hover:shadow-lg transition">
        <div class="bg-blue-100 text-blue-600 p-3 rounded-xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path d="M3 3h18l-2 13H5L3 3z"/>
                <path d="M16 16a2 2 0 11-4 0"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold text-gray-900">Pesanan</p>
            <p class="text-sm text-gray-500">Kelola pesanan masuk</p>
        </div>
    </a>

    <!-- Produk Stok -->
    <a href="{{ route('supplier.produk.index') }}"
       class="bg-white rounded-xl p-5 flex items-center gap-4 shadow hover:shadow-lg transition">
        <div class="bg-green-100 text-green-600 p-3 rounded-xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold text-gray-900">Stok Produk</p>
            <p class="text-sm text-gray-500">Kelola ketersediaan</p>
        </div>
    </a>

    <!-- Laporan -->
    <a href="#" class="bg-white rounded-xl p-5 flex items-center gap-4 shadow hover:shadow-lg transition">
        <div class="bg-purple-100 text-purple-600 p-3 rounded-xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path d="M4 19h16M6 17V7M12 17V4M18 17v-9"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold text-gray-900">Laporan</p>
            <p class="text-sm text-gray-500">Penjualan & statistik</p>
        </div>
    </a>

</div>

</body>
</html>
