<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - GrosirHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#f97316',
                        'primary-dark': '#ea580c',
                        'primary-light': '#fed7aa',
                    },
                    fontFamily: {
                        'display': ['Outfit', 'sans-serif'],
                        'body': ['DM Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Top Navigation -->
    <nav class="bg-white shadow sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="shrink-0">
                    <a href="{{ route('dropshipper.dashboard') }}" class="text-2xl font-bold text-primary">GrosirHub</a>
                </div>

                <!-- Navigation Menu -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('dropshipper.dashboard') }}" class="text-gray-700 hover:text-primary font-medium">Beranda</a>
                    <a href="{{ route('dropshipper.catalog') }}" class="text-gray-700 hover:text-primary font-medium">Produk</a>
                    <a href="{{ route('dropshipper.orders') }}" class="text-primary font-medium border-b-2 border-primary pb-1">Pesanan</a>
                    <a href="{{ route('dropshipper.order-history') }}" class="text-gray-700 hover:text-primary font-medium">Riwayat</a>
                </div>

                <!-- Right Section -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dropshipper.cart') }}" class="text-gray-700 hover:text-primary relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </a>
                    <div class="relative group">
                        <button class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-medium cursor-pointer">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </button>
                        <div class="hidden group-hover:block absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <a href="{{ route('dropshipper.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                            <div class="border-t border-gray-200 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('dropshipper.orders') }}" class="inline-flex items-center text-primary hover:text-primary-dark font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Pesanan
            </a>
        </div>

        <!-- Order Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Pesanan #{{ $order->order_code }}</h1>
                    <p class="text-gray-600">{{ $order->created_at->format('d M Y H:i') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600 mb-2">Status Pembayaran</p>
                    @if($order->payment_status === 'sudah_dibayar')
                        <span class="inline-block bg-green-100 text-green-800 px-4 py-2 rounded-full font-semibold">✓ Sudah Dibayar</span>
                    @elseif($order->payment_status === 'menunggu_pembayaran')
                        <span class="inline-block bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full font-semibold">⏳ Menunggu Pembayaran</span>
                    @else
                        <span class="inline-block bg-red-100 text-red-800 px-4 py-2 rounded-full font-semibold">✗ Pembayaran Gagal</span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 border-t border-gray-200">
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wide mb-1">Status Pengiriman</p>
                    <p class="text-lg font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wide mb-1">Kurir</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $order->courier ?? 'Belum dipilih' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wide mb-1">Nomor Resi</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $order->resi ?? 'Belum ada' }}</p>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Produk yang Dipesan</h2>
            
            <div class="space-y-4">
                @forelse($order->items as $item)
                <div class="flex items-start gap-4 pb-4 border-b border-gray-200 last:border-b-0 last:pb-0">
                    <!-- Product Image -->
                    <div class="shrink-0 w-24 h-24 bg-gray-200 rounded-lg overflow-hidden">
                        @if($item->product->primaryImage)
                            <img src="{{ asset('storage/' . $item->product->primaryImage->path) }}"
                        @elseif($item->product->images->first())
                            <img src="{{ asset('storage/' . $item->product->images->first()->path) }}" 
                                 alt="{{ $item->product->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-300 text-gray-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Product Details -->
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $item->product->name }}</h3>
                        <p class="text-sm text-gray-600 mb-3">{{ $item->product->category->name ?? 'Kategori tidak ada' }}</p>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Harga Satuan</p>
                                <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Jumlah</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $item->quantity }} pcs</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Subtotal</p>
                                <p class="text-lg font-semibold text-primary">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <p class="text-gray-500">Tidak ada produk dalam pesanan ini</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Ringkasan Pesanan</h2>
            
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-700">Subtotal ({{ $order->items->sum('quantity') }} item)</span>
                    <span class="font-semibold text-gray-900">Rp {{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}</span>
                </div>
                
                @if($order->margin > 0)
                <div class="flex justify-between items-center">
                    <span class="text-gray-700">Margin Dropshipper</span>
                    <span class="font-semibold text-primary">+ Rp {{ number_format($order->margin, 0, ',', '.') }}</span>
                </div>
                @endif

                <div class="border-t border-gray-200 pt-3 flex justify-between items-center">
                    <span class="text-lg font-semibold text-gray-900">Total</span>
                    <span class="text-2xl font-bold text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        @if($order->payment)
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Informasi Pembayaran</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Metode Pembayaran</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $order->payment->payment_method ?? 'Tidak tersedia' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Tanggal Pembayaran</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $order->payment->paid_at ? $order->payment->paid_at->format('d M Y H:i') : 'Belum dibayar' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Jumlah Pembayaran</p>
                    <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($order->payment->amount ?? $order->total, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Status</p>
                    <p class="text-lg font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex gap-3">
            <a href="{{ route('dropshipper.orders') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 font-semibold py-3 px-6 rounded-lg text-center transition">
                Kembali
            </a>
            @if($order->payment_status === 'menunggu_pembayaran')
            <a href="#" class="flex-1 bg-primary hover:bg-primary-dark text-white font-semibold py-3 px-6 rounded-lg text-center transition">
                Bayar Sekarang
            </a>
            @endif
        </div>
    </main>

    <!-- Mobile Bottom Navigation -->
    <div class="md:hidden bg-white border-t border-gray-200 fixed bottom-0 left-0 right-0 z-50">
        <div class="flex justify-around items-center h-16">
            <a href="{{ route('dropshipper.dashboard') }}" class="flex flex-col items-center justify-center text-gray-700 hover:text-primary transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="text-xs mt-1">Beranda</span>
            </a>
            <a href="{{ route('dropshipper.catalog') }}" class="flex flex-col items-center justify-center text-gray-700 hover:text-primary transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                <span class="text-xs mt-1">Produk</span>
            </a>
            <a href="{{ route('dropshipper.orders') }}" class="flex flex-col items-center justify-center text-primary transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <span class="text-xs mt-1">Pesanan</span>
            </a>
            <a href="{{ route('dropshipper.cart') }}" class="flex flex-col items-center justify-center text-gray-700 hover:text-primary transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span class="text-xs mt-1">Keranjang</span>
            </a>
        </div>
    </div>
</body>
</html>
