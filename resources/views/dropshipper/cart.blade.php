<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Keranjang Belanja - GrosirHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700;800&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                        'display': ['Archivo', 'sans-serif'],
                        'body': ['Work Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Work Sans', sans-serif;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Archivo', sans-serif;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slideOut {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        .animate-slide-up {
            animation: slideUp 0.4s ease-out;
        }

        .animate-slide-down {
            animation: slideDown 0.3s ease-out;
        }

        .animate-scale-in {
            animation: scaleIn 0.3s ease-out;
        }

        /* Cart item stagger animation */
        .cart-item:nth-child(1) { animation-delay: 0s; }
        .cart-item:nth-child(2) { animation-delay: 0.05s; }
        .cart-item:nth-child(3) { animation-delay: 0.1s; }
        .cart-item:nth-child(4) { animation-delay: 0.15s; }

        /* Cart item hover effect */
        .cart-item {
            transition: all 0.2s ease;
        }

        .cart-item:hover {
            background-color: #fffbf5;
        }

        /* Custom number input */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        /* Quantity button hover */
        .qty-btn {
            transition: all 0.2s ease;
        }

        .qty-btn:hover {
            background-color: #f97316;
            color: white;
            transform: scale(1.1);
        }

        .qty-btn:active {
            transform: scale(0.95);
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Smooth transitions */
        * {
            transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        /* Checkbox custom style */
        .cart-checkbox:checked {
            background-color: #f97316;
            border-color: #f97316;
        }

        /* Sticky summary card on scroll */
        .sticky-summary {
            position: sticky;
            top: 88px;
        }

        /* Product image hover zoom */
        .product-img-container {
            overflow: hidden;
            border-radius: 0.75rem;
        }

        .product-img {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .product-img-container:hover .product-img {
            transform: scale(1.08);
        }

        /* Price highlight animation */
        @keyframes priceHighlight {
            0%, 100% { 
                background-color: transparent;
            }
            50% { 
                background-color: #fed7aa;
            }
        }

        .price-updated {
            animation: priceHighlight 0.6s ease-out;
        }

        /* Floating checkout button on mobile */
        @media (max-width: 768px) {
            .mobile-checkout-bar {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: white;
                border-top: 2px solid #fed7aa;
                box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.1);
                z-index: 50;
            }
        }

        /* Remove button hover */
        .remove-btn {
            transition: all 0.2s ease;
        }

        .remove-btn:hover {
            color: #dc2626;
            transform: rotate(90deg);
        }

        /* Promo code input glow */
        .promo-input:focus {
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        }

        /* Save for later animation */
        .save-later-btn:hover {
            transform: translateX(4px);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Top Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="shrink-0">
                    <a href="{{ route('dropshipper.dashboard') }}" class="text-2xl font-bold text-primary font-display">GrosirHub</a>
                </div>

                <!-- Navigation Menu -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('dropshipper.dashboard') }}" class="text-gray-700 hover:text-primary font-medium">Beranda</a>
                    <a href="{{ route('dropshipper.catalog') }}" class="text-gray-700 hover:text-primary font-medium">Produk</a>
                    <a href="{{ route('dropshipper.orders') }}" class="text-gray-700 hover:text-primary font-medium">Pesanan</a>
                    <a href="{{ route('dropshipper.history') }}" class="text-gray-700 hover:text-primary font-medium">Riwayat</a>
                </div>

                <!-- Right Section -->
                <div class="flex items-center space-x-4">
                    <!-- Icons -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('dropshipper.cart') }}" class="text-primary relative">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            @if($cart && $cart->items->count() > 0)
                            <span class="absolute -top-2 -right-2 bg-primary text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-semibold">{{ $cart->items->count() }}</span>
                            @endif
                        </a>
                        <div class="relative group">
                            <button class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-semibold cursor-pointer">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </button>
                            <div class="hidden group-hover:block absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50 animate-slide-down">
                                <a href="{{ route('dropshipper.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profil Saya</a>
                                <a href="{{ route('dropshipper.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Pengaturan Akun</a>
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">Keluar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8 pb-32 md:pb-8">
        <!-- Page Header -->
        <div class="mb-6 animate-fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2 font-display">Keranjang Belanja</h1>
                    @if($cart && $cart->items->count() > 0)
                    <p class="text-gray-600">{{ $cart->items->count() }} produk siap untuk checkout</p>
                    @else
                    <p class="text-gray-600">Keranjang Anda kosong</p>
                    @endif
                </div>
                <a href="{{ route('dropshipper.catalog') }}" class="hidden md:flex items-center gap-2 text-primary hover:text-primary-dark font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Lanjut Belanja
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Cart Items Section -->
            <div class="lg:col-span-2 space-y-4">
                @if($cart && $cart->items->count() > 0)
                <!-- Select All Header -->
                <div class="bg-white rounded-xl shadow-sm p-4 flex items-center justify-between animate-slide-up">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" class="cart-checkbox w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary cursor-pointer" checked>
                        <span class="font-semibold text-gray-900">Pilih Semua ({{ $cart->items->count() }} produk)</span>
                    </label>
                    <form method="POST" action="{{ route('dropshipper.cart.clear') }}" style="display: inline;">
                        @csrf
                        <button type="button" class="clear-cart-btn text-red-600 hover:text-red-700 font-medium text-sm flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus Dipilih
                        </button>
                    </form>
                </div>

                <!-- Cart Items Loop -->
                @foreach($cart->items as $item)
                @php
                    $product = $item->product;
                    $imageUrl = $product->images->first() ? asset('storage/' . $product->images->first()->path) : asset('images/placeholder.png');
                @endphp
                <div class="cart-item bg-white rounded-xl shadow-sm p-4 md:p-6 animate-slide-up">
                    <div class="flex gap-4">
                        <!-- Checkbox -->
                        <div class="shrink-0 pt-1">
                            <input type="checkbox" class="cart-checkbox w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary cursor-pointer" checked>
                        </div>

                        <!-- Product Image -->
                        <div class="product-img-container w-24 h-24 md:w-32 md:h-32 shrink-0">
                            @if($imageUrl !== asset('images/placeholder.png'))
                            <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-xl">
                            @else
                            <div class="w-full h-full bg-linear-to-br from-orange-100 via-pink-100 to-purple-100 rounded-xl flex items-center justify-center">
                                <svg class="w-8 h-8 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            @endif
                        </div>

                        <!-- Product Details -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-4 mb-3">
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900 text-lg mb-2 leading-tight">{{ $product->name }}</h3>
                                    <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600 mb-3">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path>
                                            </svg>
                                            Stok: {{ $product->stock }} pcs
                                        </span>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('dropshipper.cart.remove', $item->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="remove-item-btn remove-btn text-gray-400 hover:text-red-600 p-2" data-item-id="{{ $item->id }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>

                            <!-- Price and Quantity -->
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    <!-- Quantity Display -->
                                    <div>
                                        <div class="text-sm text-gray-600 mb-1">Jumlah</div>
                                        <div class="text-sm font-semibold text-gray-900">{{ $item->quantity }} pcs</div>
                                    </div>

                                    <!-- Price per Unit -->
                                    <div>
                                        <div class="text-xs text-gray-500 mb-1">Harga/pcs</div>
                                        <div class="text-sm font-semibold text-gray-700">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                                    </div>
                                </div>

                                <!-- Total Price -->
                                <div class="text-right">
                                    <div class="text-sm text-gray-600 mb-1">Total Harga</div>
                                    <div class="text-2xl font-bold text-primary font-display">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                @endforeach

                @else
                <!-- Empty Cart Message -->
                <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Keranjang Anda Kosong</h3>
                    <p class="text-gray-600 mb-6">Mulai belanja untuk menambahkan produk ke keranjang</p>
                    <a href="{{ route('dropshipper.catalog') }}" class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-dark transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Lanjut Belanja
                    </a>
                </div>
                @endif
            </div>

            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky-summary space-y-4">
                    <!-- Promo Code -->
                    <div class="bg-white rounded-xl shadow-sm p-6 animate-scale-in">
                        <h3 class="font-bold text-gray-900 mb-4 font-display flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17C5.06 5.687 5 5.35 5 5zm4 1V5a1 1 0 10-1 1h1zm3 0a1 1 0 10-1-1v1h1z" clip-rule="evenodd"></path>
                                <path d="M9 11H3v5a2 2 0 002 2h4v-7zM11 18h4a2 2 0 002-2v-5h-6v7z"></path>
                            </svg>
                            Kode Promo
                        </h3>
                        <div class="flex gap-2">
                            <input type="text" placeholder="Masukkan kode promo" class="promo-input flex-1 px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <button class="px-6 py-2.5 bg-primary text-white rounded-lg font-semibold hover:bg-primary-dark whitespace-nowrap">
                                Pakai
                            </button>
                        </div>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-orange-50 text-orange-700 border border-orange-200 cursor-pointer hover:bg-orange-100">
                                GROSIR10 - 10% OFF
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-orange-50 text-orange-700 border border-orange-200 cursor-pointer hover:bg-orange-100">
                                HEMAT50K
                            </span>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="bg-white rounded-xl shadow-sm p-6 animate-scale-in">
                        <h3 class="font-bold text-gray-900 mb-6 font-display text-lg">Ringkasan Belanja</h3>
                        
                        @if($cart && $cart->items->count() > 0)
                        @php
                            $totalItems = $cart->items->count();
                            $totalQuantity = $cart->items->sum('quantity');
                            $totalPrice = $cart->items->sum(fn($item) => $item->quantity * $item->price);
                        @endphp
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex items-center justify-between text-gray-700">
                                <span>Total Harga ({{ $totalItems }} produk)</span>
                                <span class="font-semibold">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-gray-700">
                                <div class="flex items-center gap-1">
                                    <span>Biaya Pengiriman</span>
                                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-500">Dihitung di checkout</span>
                            </div>
                        </div>

                        <div class="border-t-2 border-gray-200 pt-4 mb-6">
                            <div class="flex items-center justify-between">
                                <span class="text-lg font-bold text-gray-900 font-display">Total Bayar</span>
                                <div class="text-right">
                                    <div class="text-3xl font-bold text-primary font-display">Rp {{ number_format($totalPrice, 0, ',', '.') }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $totalQuantity }} pcs • {{ $totalItems }} produk</div>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('dropshipper.checkout') }}">
                            @csrf
                            <button type="submit" class="w-full bg-primary text-white py-4 rounded-xl font-bold text-lg hover:bg-primary-dark transition shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                Lanjut ke Pembayaran
                            </button>
                        </form>

                        <div class="mt-4 flex items-center justify-center gap-3 text-sm text-gray-600">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Transaksi Aman
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"></path>
                                </svg>
                                Pengiriman Cepat
                            </div>
                        </div>
                        @else
                        <div class="text-center py-6">
                            <p class="text-gray-600">Belum ada produk di keranjang</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Mobile Checkout Bar -->
    @if($cart && $cart->items->count() > 0)
    <div class="mobile-checkout-bar md:hidden p-4">
        <div class="flex items-center justify-between mb-3">
            <div>
                <div class="text-xs text-gray-600">Total</div>
                <div class="text-2xl font-bold text-primary font-display">Rp {{ number_format($totalPrice, 0, ',', '.') }}</div>
            </div>
            <form method="POST" action="{{ route('dropshipper.checkout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="px-8 py-3 bg-primary text-white rounded-xl font-bold hover:bg-primary-dark transition shadow-lg">
                    Checkout
                </button>
            </form>
        </div>
        <div class="text-xs text-center text-gray-500">{{ $totalQuantity }} pcs • {{ $totalItems }} produk dipilih</div>
    </div>
    @endif

    <script>
        // Quantity adjustment functionality
        document.querySelectorAll('.qty-btn').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentElement.querySelector('input[type="number"]');
                const currentValue = parseInt(input.value);
                const min = parseInt(input.min);
                
                if (this.querySelector('path').getAttribute('d').includes('M20 12H4')) {
                    // Minus button
                    if (currentValue > min) {
                        input.value = currentValue - 1;
                        updatePrice(this.closest('.cart-item'));
                    }
                } else {
                    // Plus button
                    input.value = currentValue + 1;
                    updatePrice(this.closest('.cart-item'));
                }
            });
        });

        // Update price when quantity changes
        function updatePrice(cartItem) {
            const priceElement = cartItem.querySelector('.text-2xl.font-bold.text-primary');
            priceElement.classList.add('price-updated');
            setTimeout(() => {
                priceElement.classList.remove('price-updated');
            }, 600);
        }

        // Select all checkbox functionality
        const selectAllCheckbox = document.querySelector('.bg-white.rounded-xl.shadow-sm.p-4 .cart-checkbox');
        const itemCheckboxes = document.querySelectorAll('.cart-item .cart-checkbox');

        selectAllCheckbox?.addEventListener('change', function() {
            itemCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Individual checkbox change
        itemCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const allChecked = Array.from(itemCheckboxes).every(cb => cb.checked);
                if (selectAllCheckbox) {
                    selectAllCheckbox.checked = allChecked;
                }
            });
        });

        // Function to show alert modal
        function showAlert(message, type = 'success') {
            const alertDiv = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-50 border-green-200 text-green-700' : 'bg-red-50 border-red-200 text-red-700';
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
            
            alertDiv.innerHTML = `
                <div class="fixed top-4 right-4 max-w-md ${bgColor} border px-4 py-3 rounded-lg shadow-lg flex items-center gap-3 animate-slide-up z-50">
                    <i class="fas ${icon}"></i>
                    <p>${message}</p>
                </div>
            `;
            
            document.body.appendChild(alertDiv);
            
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }

        // Remove individual item via AJAX
        document.querySelectorAll('.remove-item-btn').forEach(btn => {
            btn.addEventListener('click', async function(e) {
                e.preventDefault();
                
                if (!confirm('Yakin hapus item ini?')) {
                    return;
                }
                
                const itemId = this.dataset.itemId;
                const form = this.closest('form');
                const cartItem = this.closest('.cart-item');
                
                try {
                    const response = await fetch(form.action, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok && data.status === 'success') {
                        cartItem.style.animation = 'slideOut 0.3s ease-out forwards';
                        setTimeout(() => {
                            cartItem.remove();
                            showAlert('Item berhasil dihapus dari keranjang', 'success');
                            
                            // Reload cart if empty
                            if (document.querySelectorAll('.cart-item').length === 0) {
                                location.reload();
                            }
                        }, 300);
                    } else {
                        showAlert(data.message || 'Gagal menghapus item', 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showAlert('Terjadi kesalahan saat menghapus item', 'error');
                }
            });
        });

        // Clear entire cart via AJAX
        document.querySelector('.clear-cart-btn')?.addEventListener('click', async function(e) {
            e.preventDefault();
            
            if (!confirm('Yakin hapus semua item dari keranjang?')) {
                return;
            }
            
            const form = this.closest('form');
            
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    }
                });
                
                const data = await response.json();
                
                if (response.ok && data.status === 'success') {
                    showAlert('Keranjang berhasil dikosongkan', 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert(data.message || 'Gagal mengosongkan keranjang', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('Terjadi kesalahan saat mengosongkan keranjang', 'error');
            }
        });
    </script>
</body>
</html>