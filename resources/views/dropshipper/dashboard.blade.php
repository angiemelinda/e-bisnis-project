<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrosirHub - Belanja Grosir Online</title>
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
<body class="bg-gray-50">
    <!-- Top Navigation -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="#" class="text-2xl font-bold text-primary">GrosirHub</a>
                </div>

                <!-- Navigation Menu -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('dropshipper.dashboard') }}" class="text-primary font-medium border-b-2 border-primary pb-1">Beranda</a>
                    <a href="{{ route('dropshipper.catalog') }}" class="text-gray-700 hover:text-primary font-medium">Produk</a>
                    <a href="{{ route('dropshipper.orders') }}" class="text-gray-700 hover:text-primary font-medium">Pesanan</a>
                    <a href="{{ route('dropshipper.order-history') }}" class="text-gray-700 hover:text-primary font-medium">Riwayat</a>
                </div>

                <!-- Right Section with Search and Icons -->
                <div class="flex items-center space-x-4">
                    <!-- Search Bar -->
                    <div class="hidden md:block w-64">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent" placeholder="Cari produk...">
                        </div>
                    </div>

                    <!-- Icons -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('dropshipper.cart') }}" class="text-gray-700 hover:text-primary relative">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            @php
                                $cartItems = auth()->user() ? \App\Models\Order::where('user_id', auth()->id())->where('status', 'belum_dibayar')->first() : null;
                                $cartCount = $cartItems ? $cartItems->items->count() : 0;
                            @endphp
                            @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-primary text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ $cartCount }}</span>
                            @endif
                        </a>
                        <div class="relative group">
                            <button class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-medium cursor-pointer">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </button>
                            <!-- Dropdown menu -->
                            <div class="hidden group-hover:block absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="{{ route('dropshipper.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                                <a href="{{ route('dropshipper.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pengaturan Akun</a>
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
        </div>

        <!-- Mobile Search Bar -->
        <div class="md:hidden px-4 pb-4">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent" placeholder="Cari produk...">
            </div>
        </div>

        <!-- Mobile Bottom Navigation -->
        <div class="md:hidden bg-white border-t border-gray-200 fixed bottom-0 left-0 right-0 z-50">
            <div class="flex justify-around items-center h-16">
                <a href="{{ route('dropshipper.dashboard') }}" class="flex flex-col items-center justify-center text-primary transition">
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
                <a href="{{ route('dropshipper.orders') }}" class="flex flex-col items-center justify-center text-gray-700 hover:text-primary transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span class="text-xs mt-1">Pesanan</span>
                </a>
                <a href="{{ route('dropshipper.order-history') }}" class="flex flex-col items-center justify-center text-gray-700 hover:text-primary transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span class="text-xs mt-1">Riwayat</span>
                </a>
                <a href="{{ route('dropshipper.cart') }}" class="flex flex-col items-center justify-center text-gray-700 hover:text-primary transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span class="text-xs mt-1">Keranjang</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Hero Banner -->
        <div class="mb-8 bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl overflow-hidden">
            <div class="flex items-center justify-between p-8 md:p-12">
                <div class="text-white max-w-xl">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Belanja Grosir dengan Harga Terbaik!</h2>
                    <p class="text-lg mb-6 text-orange-100">Dapatkan produk berkualitas langsung dari supplier terpercaya. Minimum order rendah, profit maksimal!</p>
                    <button class="bg-white text-primary px-8 py-3 rounded-lg font-semibold hover:bg-gray-50 transition">Mulai Belanja</button>
                </div>
                <div class="hidden md:block">
                    <div class="w-64 h-64 bg-white/20 rounded-full"></div>
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Produk Teratas</h3>
                <a href="{{ route('dropshipper.catalog') }}" class="flex items-center text-primary hover:text-primary-dark">
                    <span class="mr-1">Lihat Semua</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @forelse($topProducts as $product)
                <div class="bg-white rounded-xl overflow-hidden hover:shadow-xl transition-all duration-300 cursor-pointer group">
                    <div class="relative">
                        @if($product->primaryImage)
                            <img src="{{ asset('storage/' . $product->primaryImage->path) }}" 
                                alt="{{ $product->name }}"
                                 class="w-full h-32 object-cover">
                        @else
                            <div class="w-full h-32 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        @if($product->discount > 0)
                        <div class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">-{{ $product->discount }}%</div>
                        @endif
                        <button class="absolute top-2 right-2 w-8 h-8 bg-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="p-3">
                        <h4 class="font-medium text-gray-900 text-sm mb-2 line-clamp-2">{{ $product->name }}</h4>
                        <div class="mb-2">
                            <div class="text-xs text-gray-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            <div class="text-lg font-bold text-primary">Rp {{ number_format($product->price - ($product->price * $product->discount / 100), 0, ',', '.') }}</div>
                        </div>
                        <div class="text-xs text-gray-600 mb-3">Min. order {{ $product->min_order ?? 1 }} pcs</div>
                        <a href="{{ route('dropshipper.product.show', $product->id) }}" class="w-full block bg-primary text-white py-2 rounded-lg text-sm font-medium hover:bg-primary-dark transition text-center">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-6 text-center py-12">
                    <p class="text-gray-500 text-lg">Tidak ada produk tersedia</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- My Orders Section -->
        <div class="mb-8 bg-gradient-to-r from-orange-50 to-white rounded-xl p-6 border border-orange-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900">Pesanan Saya</h3>
                <a href="{{ route('dropshipper.orders') }}" class="text-primary hover:text-primary-dark font-medium">Lihat Semua →</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-lg border border-gray-200 hover:shadow-md transition cursor-pointer">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-gray-600 text-sm">Belum Bayar</div>
                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                            <span class="text-yellow-600 font-bold text-lg">{{ $pendingPayment }}</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Segera selesaikan pembayaran</p>
                </div>
                <a href="{{ route('dropshipper.orders') }}?status=dikemas" class="block bg-white p-4 rounded-lg border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-gray-600 text-sm">Dikemas</div>
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 font-bold text-lg">{{ $packing }}</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Pesanan sedang disiapkan</p>
                </a>
                <a href="{{ route('dropshipper.orders') }}?status=dikirim" class="block bg-white p-4 rounded-lg border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-gray-600 text-sm">Dikirim</div>
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                            <span class="text-purple-600 font-bold text-lg">{{ $shipped }}</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Dalam perjalanan ke pelanggan</p>
                </a>
                <a href="{{ route('dropshipper.orders') }}?status=selesai" class="block bg-white p-4 rounded-lg border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-gray-600 text-sm">Selesai</div>
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="text-green-600 font-bold text-lg">{{ $completed }}</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Pesanan telah diterima</p>
                </a>
            </div>
        </div>
    </main>
</body>
</html>
                  
