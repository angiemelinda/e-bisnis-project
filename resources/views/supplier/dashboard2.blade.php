@extends('layouts.supplier')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Produk -->
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-600">Total Produk</p>
                    <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $totalProduk }}</p>
                    <p class="mt-1 text-xs text-blue-500">+{{ $totalProdukLastMonth }} dari bulan lalu</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Pesanan -->
        <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-600">Total Pesanan</p>
                    <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $totalOrders }}</p>
                    <p class="mt-1 text-xs text-green-500">+{{ $ordersThisMonth }} bulan ini</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Stok -->
        <div class="bg-gradient-to-r from-amber-50 to-amber-100 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-amber-600">Total Stok</p>
                    <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $totalStok }}</p>
                    <p class="mt-1 text-xs text-amber-500">{{ $stokTerjual }} terjual bulan ini</p>
                </div>
                <div class="p-3 bg-amber-100 rounded-lg">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Produk Habis -->
        <div class="bg-gradient-to-r from-red-50 to-red-100 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-red-600">Stok Menipis</p>
                    <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $outOfStock }}</p>
                    <p class="mt-1 text-xs text-red-500">perlu perhatian</p>
                </div>
                <div class="p-3 bg-red-100 rounded-lg">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Pesanan Terbaru -->
    <div class="bg-white rounded-xl shadow p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Pesanan Terbaru</h2>
            <a href="{{ route('supplier.pesanan.index') }}" class="text-sm text-orange-500 hover:underline">Lihat Semua</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Pesanan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pesananTerbaru as $pesanan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $pesanan->kode }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pesanan->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($pesanan->status == 'diproses') bg-yellow-100 text-yellow-800
                                @elseif($pesanan->status == 'dikirim') bg-blue-100 text-blue-800
                                @elseif($pesanan->status == 'selesai') bg-green-100 text-green-800
                                @elseif($pesanan->status == 'dibatalkan') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($pesanan->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('supplier.pesanan.show', $pesanan->id) }}" class="text-orange-600 hover:text-orange-900">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            Belum ada pesanan terbaru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- PRODUK TERLARIS & STOK MENIPIS -->
    <div class="bg-white p-6 rounded-xl shadow space-y-4 mb-8">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-900">🔥 Produk Terlaris & Stok Rendah</h2>
            <a href="{{ route('supplier.produk.index') }}" class="text-sm text-orange-500 hover:underline">
                Kelola Produk
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($produkTeratas as $produk)
            <div class="flex gap-4 bg-gray-50 rounded-xl p-4 hover:shadow transition">
                <!-- Product Image -->
                <div class="w-20 h-20 rounded-lg overflow-hidden bg-gray-200 flex-shrink-0">
                    @if($produk->primaryImage)
                        <img 
                            src="{{ asset('storage/' . $produk->primaryImage->path) }}" 
                            class="w-full h-full object-cover"
                            alt="{{ $produk->name }}"
                            onerror="this.onerror=null; this.src='https://via.placeholder.com/150'">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900 leading-tight">
                        {{ $produk->name }}
                    </h3>

                    <!-- Price -->
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-orange-600 font-semibold">
                            Rp {{ number_format($produk->price, 0, ',', '.') }}
                        </span>
                    </div>

                    <!-- Stock -->
                    <div class="mt-2">
                        @if($produk->stock <= 3)
                            <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded-full">
                                ⚠ Stok hampir habis ({{ $produk->stock }})
                            </span>
                        @else
                            <span class="text-xs bg-green-100 text-green-600 px-2 py-1 rounded-full">
                                Stok: {{ $produk->stock }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-5">
        <!-- Tambah Produk -->
        <a href="{{ route('supplier.produk.create') }}"
           class="bg-white rounded-xl p-5 flex items-center gap-4 shadow hover:shadow-lg transition">
            <div class="bg-orange-100 text-orange-600 p-3 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-gray-900">Stok Produk</p>
                <p class="text-sm text-gray-500">Kelola ketersediaan</p>
            </div>
        </a>

    </div>
</div>
@endsection