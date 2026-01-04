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
 
       <!-- Ringkasan Pesanan -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">

    <!-- Pesanan Baru -->
    <div class="bg-white border-l-4 border-yellow-400 rounded-2xl p-4 shadow-sm hover:shadow-lg transition-all duration-200 hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Pesanan Baru</p>
                <h3 class="text-2xl font-bold text-yellow-500">
                    {{ $countBaru ?? 0 }}
                </h3>
            </div>
            <div class="p-3 bg-yellow-100 rounded-xl text-yellow-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6 2h12v20l-3-2-3 2-3-2-3 2V2z"/>
                </svg>
            </div>
        </div>
        <p class="text-xs text-gray-400 mt-2">Menunggu konfirmasi</p>
    </div>

    <!-- Diproses -->
    <div class="bg-white border-l-4 border-blue-500 rounded-2xl p-4 shadow-sm hover:shadow-lg transition-all duration-200 hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Diproses</p>
                <h3 class="text-2xl font-bold text-blue-500">
                    {{ $countDiproses ?? 0 }}
                </h3>
            </div>
            <div class="p-3 bg-blue-100 rounded-xl text-blue-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v6l4 2"/>
                    <circle cx="12" cy="12" r="9"/>
                </svg>
            </div>
        </div>
        <p class="text-xs text-gray-400 mt-2">Sedang dikemas</p>
    </div>

    <!-- Dikirim -->
    <div class="bg-white border-l-4 border-orange-500 rounded-2xl p-4 shadow-sm hover:shadow-lg transition-all duration-200 hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Dikirim</p>
                <h3 class="text-2xl font-bold text-orange-500">
                    {{ $countDikirim ?? 0 }}
                </h3>
            </div>
            <div class="p-3 bg-orange-100 rounded-xl text-orange-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 7h13l3 5v5h-3a2 2 0 11-4 0H9a2 2 0 11-4 0H3V7z"/>
                </svg>
            </div>
        </div>
        <p class="text-xs text-gray-400 mt-2">Dalam pengiriman</p>
    </div>

    <!-- Selesai -->
    <div class="bg-white border-l-4 border-green-500 rounded-2xl p-4 shadow-sm hover:shadow-lg transition-all duration-200 hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Selesai</p>
                <h3 class="text-2xl font-bold text-green-500">
                    {{ $countSelesai ?? 0 }}
                </h3>
            </div>
            <div class="p-3 bg-green-100 rounded-xl text-green-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        </div>
        <p class="text-xs text-gray-400 mt-2">Transaksi berhasil</p>
    </div>

    <!-- Dibatalkan -->
    <div class="bg-white border-l-4 border-red-500 rounded-2xl p-4 shadow-sm hover:shadow-lg transition-all duration-200 hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Dibatalkan</p>
                <h3 class="text-2xl font-bold text-red-500">
                    {{ $countBatal ?? 0 }}
                </h3>
            </div>
            <div class="p-3 bg-red-100 rounded-xl text-red-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
        </div>
        <p class="text-xs text-gray-400 mt-2">Pesanan dibatalkan</p>
    </div>

</div>

<!-- Daftar Pesanan -->
<div class="bg-white rounded-2xl shadow border overflow-hidden">

    <!-- Header (lebih tipis) -->
    <div class="px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-400 text-white flex items-center justify-between">
        <h2 class="text-base font-semibold">
            Daftar Pesanan
        </h2>
        <span class="text-xs bg-white/20 px-3 py-1 rounded-full">
            {{ $pesanan->count() }} Pesanan
        </span>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-orange-50 border-b">
                <tr class="text-gray-600 uppercase text-xs tracking-wider">
                    <th class="px-6 py-4 text-left">ID</th>
                    <th class="px-6 py-4 text-left">Tanggal</th>
                    <th class="px-6 py-4 text-left">Produk</th>
                    <th class="px-6 py-4 text-right">Total</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($pesanan as $order)
                <tr class="hover:bg-orange-50/40 transition">
                    <!-- Order -->
                    <td class="px-6 py-5">
                        <div class="font-semibold text-gray-800">
                            #{{ $order->kode_pesanan }}
                        </div>
                        <div class="text-xs text-gray-400">
                            {{ $order->created_at->format('d M Y • H:i') }}
                        </div>
                    </td>

                    <!-- Pemesan -->
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-semibold text-xs">
                                AP
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">
                                    Andi Pratama
                                </div>
                                <div class="text-xs text-gray-400">
                                    Pemesan
                                </div>
                            </div>
                        </div>
                    </td>

                    <!-- Produk -->
                    <td class="px-6 py-5">
                        <div class="text-gray-700">
                            {{ $order->items->take(3)->pluck('nama_produk')->implode(', ') }}
                            @if($order->items->count() > 3)
                                <span class="text-gray-400">
                                    +{{ $order->items->count() - 3 }} lainnya
                                </span>
                            @endif
                        </div>
                        <div class="text-xs text-gray-400 mt-1">
                            {{ $order->items->count() }} produk
                        </div>
                    </td>

                    <!-- Total -->
                    <td class="px-6 py-5 text-right font-semibold text-gray-800">
                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                    </td>

                    <!-- Status -->
                    <td class="px-6 py-5 text-center">
                        @php
                            $statusColor = match($order->status) {
                                'baru'       => 'bg-yellow-100 text-yellow-700',
                                'diproses'   => 'bg-blue-100 text-blue-700',
                                'dikirim'    => 'bg-orange-100 text-orange-700',
                                'selesai'    => 'bg-green-100 text-green-700',
                                'dibatalkan' => 'bg-red-100 text-red-700',
                                default      => 'bg-gray-100 text-gray-600'
                            };
                        @endphp

                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>

                    <!-- Aksi -->
                    <td class="px-6 py-5 text-center">
                        <div class="inline-flex gap-2">
                            <a href="{{ route('supplier.pesanan.show', $order->id) }}"
                               class="px-3 py-1.5 rounded-lg border border-orange-200 text-orange-600 hover:bg-orange-50 transition text-xs">
                                Detail
                            </a>

                            @if(!in_array($order->status, ['selesai','dibatalkan']))
                            <a href="{{ route('supplier.pesanan.proses', $order->id) }}"
                               class="px-3 py-1.5 rounded-lg bg-orange-500 text-white hover:bg-orange-600 transition text-xs">
                                Proses
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                        Belum ada pesanan masuk
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
