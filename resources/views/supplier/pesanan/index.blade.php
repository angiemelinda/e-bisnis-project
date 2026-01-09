@extends('layouts.supplier')

@section('title', 'Pesanan')
@section('header', 'Pesanan')

@section('content')
 
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

@endsection