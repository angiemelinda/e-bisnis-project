<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk - GrosirHub</title>
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

        /* Custom Animations */
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

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
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

        .animate-slide-down {
            animation: slideDown 0.3s ease-out;
        }

        .animate-fade-in {
            animation: fadeIn 0.4s ease-out;
        }

        .animate-scale-in {
            animation: scaleIn 0.3s ease-out;
        }

        /* Product Card Hover Effects */
        .product-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .product-card:hover {
            transform: translateY(-4px);
        }

        .product-image {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        /* Filter Checkbox Style */
        .filter-checkbox:checked {
            background-color: #f97316;
            border-color: #f97316;
        }

        /* Price Range Slider */
        input[type="range"] {
            -webkit-appearance: none;
            appearance: none;
            background: transparent;
            cursor: pointer;
        }

        input[type="range"]::-webkit-slider-track {
            background-color: #fed7aa;
            height: 6px;
            border-radius: 3px;
        }

        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            background-color: #f97316;
            height: 20px;
            width: 20px;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 2px 8px rgba(249, 115, 22, 0.4);
            margin-top: -7px;
        }

        input[type="range"]::-moz-range-track {
            background-color: #fed7aa;
            height: 6px;
            border-radius: 3px;
        }

        input[type="range"]::-moz-range-thumb {
            background-color: #f97316;
            height: 20px;
            width: 20px;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 2px 8px rgba(249, 115, 22, 0.4);
        }

        /* Scrollbar Styling */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
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

        /* Badge pulse animation */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
            }
        }

        .badge-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Grid stagger animation */
        .product-card:nth-child(1) { animation-delay: 0s; }
        .product-card:nth-child(2) { animation-delay: 0.05s; }
        .product-card:nth-child(3) { animation-delay: 0.1s; }
        .product-card:nth-child(4) { animation-delay: 0.15s; }
        .product-card:nth-child(5) { animation-delay: 0.2s; }
        .product-card:nth-child(6) { animation-delay: 0.25s; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Top Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="index.html" class="text-2xl font-bold text-primary font-display">GrosirHub</a>
                </div>

                <!-- Navigation Menu -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('dropshipper.dashboard') }}" class="text-gray-700 hover:text-primary font-medium {{ request()->routeIs('dropshipper.dashboard') ? 'text-primary font-semibold border-b-2 border-primary pb-1' : '' }}">Beranda</a>
                    <a href="{{ route('dropshipper.catalog') }}" class="{{ request()->routeIs('dropshipper.catalog') ? 'text-primary font-semibold border-b-2 border-primary pb-1' : 'text-gray-700 hover:text-primary' }} font-medium">Produk</a>
                    <a href="{{ route('dropshipper.orders') }}" class="text-gray-700 hover:text-primary font-medium {{ request()->routeIs('dropshipper.orders') ? 'text-primary font-semibold border-b-2 border-primary pb-1' : '' }}">Pesanan</a>
                    <a href="{{ route('dropshipper.order-history') }}" class="text-gray-700 hover:text-primary font-medium {{ request()->routeIs('dropshipper.order-history') ? 'text-primary font-semibold border-b-2 border-primary pb-1' : '' }}">Riwayat</a>
                </div>

                <!-- Right Section -->
                <div class="flex items-center space-x-4">
                    <!-- Search Bar -->
                    <form action="{{ route('dropshipper.catalog') }}" method="GET" class="hidden md:block w-64">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Cari produk..." onkeypress="if(event.key==='Enter') this.form.submit();">
                        </div>
                    </form>

                    <!-- Icons -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('dropshipper.cart') }}" class="text-gray-700 hover:text-primary relative">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            @php
                                $cartItems = \App\Models\Order::where('user_id', auth()->id())->where('status', 'belum_dibayar')->with('items')->first();
                                $cartCount = $cartItems ? $cartItems->items->count() : 0;
                            @endphp
                            @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-primary text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-semibold">{{ $cartCount }}</span>
                            @endif
                        </a>
                        <div class="relative group">
                            <button class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-semibold cursor-pointer">
                                JD
                            </button>
                            <div class="hidden group-hover:block absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50 animate-slide-down">
                                <a href="{{ route('dropshipper.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profil Saya</a>
                                <a href="{{ route('dropshipper.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Pengaturan Akun</a>
                                <hr class="my-1">
                                <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Keluar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Search Bar -->
        <form action="{{ route('dropshipper.catalog') }}" method="GET" class="md:hidden px-4 pb-4">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Cari produk..." onkeypress="if(event.key==='Enter') this.form.submit();">
            </div>
        </form>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8 mb-20 md:mb-0">
        <!-- Breadcrumb -->
        <div class="flex items-center space-x-2 text-sm text-gray-600 mb-6">
            <a href="index.html" class="hover:text-primary">Beranda</a>
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-primary font-medium">Katalog Produk</span>
        </div>

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3 font-display">Katalog Produk</h1>
            <p class="text-gray-600 text-lg">Temukan produk grosir terbaik dengan harga kompetitif</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Sidebar Filters -->
            <aside class="w-full lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-xl shadow-sm p-6 sticky top-20">
                    <form method="GET" action="{{ route('dropshipper.catalog') }}" id="filterForm">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-lg text-gray-900 font-display">Filter</h3>
                            <a href="{{ route('dropshipper.catalog') }}" class="text-primary text-sm font-medium hover:text-primary-dark">Reset</a>
                        </div>

                        <!-- Category Filter -->
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-900 mb-3 font-display">Kategori</h4>
                            <div class="space-y-2 max-h-64 overflow-y-auto custom-scrollbar">
                                @forelse($categories as $category)
                                <label class="flex items-center cursor-pointer hover:bg-gray-50 p-2 rounded-lg">
                                    <input type="checkbox" 
                                        name="categories[]" 
                                        value="{{ $category->id }}"
                                        class="category-checkbox filter-checkbox w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary mr-3" 
                                        {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }}
                                        onchange="document.getElementById('filterForm').submit();">
                                    <span class="text-gray-700 text-sm">{{ $category->name }}</span>
                                    <span class="ml-auto text-xs text-gray-400">({{ $category->products_count ?? 0 }})</span>
                                </label>
                                @empty
                                <p class="text-gray-500 text-sm">Tidak ada kategori</p>
                                @endforelse
                            </div>
                        </div>

                        <hr class="my-6 border-gray-200">

                        <!-- Price Range Filter -->
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-900 mb-3 font-display">Rentang Harga</h4>
                            <div class="space-y-4">
                                <div class="flex items-center space-x-2">
                                    <input type="number" 
                                        name="price_min" 
                                        placeholder="Min" 
                                        value="{{ request('price_min') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    <span class="text-gray-400">-</span>
                                    <input type="number" 
                                        name="price_max" 
                                        placeholder="Max" 
                                        value="{{ request('price_max') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                                <button type="button" 
                                    onclick="document.getElementById('filterForm').submit();" 
                                    class="w-full px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-dark transition">
                                    Cari Harga
                                </button>
                            </div>
                        </div>

                        <hr class="my-6 border-gray-200">

                        <!-- Stock Filter -->
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-900 mb-3 font-display">Ketersediaan</h4>
                            <label class="flex items-center cursor-pointer hover:bg-gray-50 p-2 rounded-lg">
                                <input type="checkbox" 
                                    name="in_stock"
                                    value="1"
                                    class="filter-checkbox w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary mr-3"
                                    {{ request('in_stock') ? 'checked' : '' }}
                                    onchange="document.getElementById('filterForm').submit();">
                                <span class="text-gray-700 text-sm">Hanya Stok Tersedia</span>
                            </label>
                        </div>
                    </form>
                </div>
            </aside>

            <!-- Products Grid -->
            <div class="flex-1">
                <!-- Sort & View Options -->
                <div class="bg-white rounded-xl shadow-sm p-4 mb-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div class="flex items-center space-x-2">
                        <span class="text-gray-600 text-sm">Menampilkan</span>
                        <span class="font-bold text-gray-900">{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</span>
                        <span class="text-gray-600 text-sm">dari</span>
                        <span class="font-bold text-gray-900">{{ $products->total() }}</span>
                        <span class="text-gray-600 text-sm">produk</span>
                    </div>
                    
                    <div class="flex items-center space-x-4 w-full md:w-auto">
                        <div class="flex items-center space-x-2">
                            <span class="text-gray-600 text-sm">Urutkan:</span>
                            <form method="GET" action="{{ route('dropshipper.catalog') }}" id="sortForm" class="inline">
                                <!-- Preserve existing filter parameters -->
                                @foreach(request()->query() as $key => $value)
                                    @if($key !== 'sort' && $key !== 'page')
                                        @if(is_array($value))
                                            @foreach($value as $v)
                                                <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                            @endforeach
                                        @else
                                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                        @endif
                                    @endif
                                @endforeach
                                <select name="sort" onchange="document.getElementById('sortForm').submit();" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent cursor-pointer">
                                    <option value="">Terpopuler</option>
                                    <option value="termurah" {{ request('sort') === 'termurah' ? 'selected' : '' }}>Harga Terendah</option>
                                    <option value="termahal" {{ request('sort') === 'termahal' ? 'selected' : '' }}>Harga Tertinggi</option>
                                    <option value="terbaru" {{ request('sort') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                    <option value="terlaris" {{ request('sort') === 'terlaris' ? 'selected' : '' }}>Terlaris</option>
                                </select>
                            </form>
                        </div>
                        <div class="hidden md:flex items-center space-x-2">
                            <button class="p-2 border border-gray-300 rounded-lg hover:border-primary hover:text-primary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                            </button>
                            <button class="p-2 border border-primary bg-primary/5 text-primary rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Active Filters -->
                <div class="flex flex-wrap items-center gap-2 mb-6">
                    @php
                        $hasFilters = request('search') || !empty($selectedCategories) || request('price_min') || request('price_max') || request('in_stock') || request('sort');
                    @endphp
                    
                    @if($hasFilters)
                        <span class="text-sm text-gray-600 font-medium">Filter Aktif:</span>
                        
                        @if(request('search'))
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-50 text-blue-700 border border-blue-200">
                                🔍 {{ request('search') }}
                                <a href="{{ route('dropshipper.catalog', array_diff_key(request()->query(), ['search' => null])) }}" class="ml-2 hover:text-blue-900 font-bold">×</a>
                            </span>
                        @endif
                        
                        @if(!empty($selectedCategories))
                            @php
                                $categories_selected = \App\Models\Category::whereIn('id', $selectedCategories)->get();
                            @endphp
                            @foreach($categories_selected as $cat)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-primary/10 text-primary border border-primary/20">
                                    📁 {{ $cat->name }}
                                    <a href="{{ route('dropshipper.catalog', array_diff_key(request()->query(), ['categories' => null])) }}" class="ml-2 hover:text-primary-dark font-bold">×</a>
                                </span>
                            @endforeach
                        @endif
                        
                        @if(request('price_min') || request('price_max'))
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-50 text-green-700 border border-green-200">
                                💰 
                                @if(request('price_min'))
                                    Rp {{ number_format(request('price_min'), 0, ',', '.') }}
                                @endif
                                @if(request('price_min') && request('price_max'))
                                    -
                                @endif
                                @if(request('price_max'))
                                    Rp {{ number_format(request('price_max'), 0, ',', '.') }}
                                @endif
                                <a href="{{ route('dropshipper.catalog', array_diff_key(request()->query(), ['price_min' => null, 'price_max' => null])) }}" class="ml-2 hover:text-green-900 font-bold">×</a>
                            </span>
                        @endif
                        
                        @if(request('in_stock'))
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-yellow-50 text-yellow-700 border border-yellow-200">
                                ✓ Stok Tersedia
                                <a href="{{ route('dropshipper.catalog', array_diff_key(request()->query(), ['in_stock' => null])) }}" class="ml-2 hover:text-yellow-900 font-bold">×</a>
                            </span>
                        @endif
                        
                        @if(request('sort'))
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-purple-50 text-purple-700 border border-purple-200">
                                📊 
                                @switch(request('sort'))
                                    @case('termurah') Harga Terendah @break
                                    @case('termahal') Harga Tertinggi @break
                                    @case('terbaru') Terbaru @break
                                    @case('terlaris') Terlaris @break
                                @endswitch
                                <a href="{{ route('dropshipper.catalog', array_diff_key(request()->query(), ['sort' => null])) }}" class="ml-2 hover:text-purple-900 font-bold">×</a>
                            </span>
                        @endif
                    @else
                        <span class="text-sm text-gray-500 italic">Tidak ada filter aktif</span>
                    @endif
                </div>

                <!-- Product Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
                    @forelse($products as $product)
                    <!-- Product Card -->
                    <div class="product-card bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl cursor-pointer group animate-scale-in">
                        <div class="relative overflow-hidden">
                            @if($product->primaryImage)
                                <img src="{{ asset('storage/' . $product->primaryImage->path) }}" alt="{{ $product->name }}" class="product-image aspect-square object-cover">
                            @else
                                <div class="product-image aspect-square bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400 text-sm">📷 Tidak ada gambar</span>
                                </div>
                            @endif
                            <button class="absolute top-2 right-2 w-9 h-9 bg-white/90 backdrop-blur rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition shadow-lg hover:bg-white hover:scale-110">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-900 text-sm mb-2 line-clamp-2 leading-snug">{{ $product->name }}</h4>
                            <div class="mb-2">
                                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                                    {{ $product->category->name ?? 'Tanpa Kategori' }}
                                </span>
                            </div>
                            <div class="mb-3">
                                <div class="flex items-baseline gap-1">
                                    <span class="text-xl font-bold text-primary font-display">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    <span class="text-xs text-gray-500">/pcs</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mb-3">
                                <div class="text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded-full">
                                    Stok: {{ $product->stock }}
                                </div>
                                @if($product->stock > 0)
                                    <div class="text-xs font-medium text-green-600 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
                                        </svg>
                                        Tersedia
                                    </div>
                                @else
                                    <div class="text-xs font-medium text-red-600">
                                        Habis
                                    </div>
                                @endif
                            </div>
                            <form action="{{ route('dropshipper.cart.add') }}" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="flex items-center gap-2 mb-3">
                                    <label class="text-sm text-gray-600">Jumlah:</label>
                                    <div class="flex items-center border rounded-lg overflow-hidden">
                                        <button type="button" class="quantity-decrease px-2 py-1 bg-gray-100 hover:bg-gray-200" data-product-id="{{ $product->id }}">-</button>
                                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                            class="quantity-input w-12 text-center border-0 focus:ring-0 focus:outline-none" 
                                            data-product-id="{{ $product->id }}">
                                        <button type="button" class="quantity-increase px-2 py-1 bg-gray-100 hover:bg-gray-200" data-product-id="{{ $product->id }}">+</button>
                                    </div>
                                    <span class="text-xs text-gray-500">Max: {{ $product->stock }}</span>
                                </div>
                                <button type="submit" class="w-full bg-primary text-white py-2.5 rounded-lg text-sm font-semibold hover:bg-primary-dark transition flex items-center justify-center gap-2 shadow-sm hover:shadow-md" @disabled($product->stock <= 0)>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    Tambah ke Keranjang
                                </button>
                            </form>
                            
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    // Quantity controls
                                    document.querySelectorAll('.quantity-increase').forEach(button => {
                                        button.addEventListener('click', function() {
                                            const productId = this.getAttribute('data-product-id');
                                            const input = document.querySelector(`.quantity-input[data-product-id="${productId}"]`);
                                            const max = parseInt(input.getAttribute('max'));
                                            let value = parseInt(input.value) || 1;
                                            if (value < max) {
                                                input.value = value + 1;
                                            }
                                        });
                                    });

                                    document.querySelectorAll('.quantity-decrease').forEach(button => {
                                        button.addEventListener('click', function() {
                                            const productId = this.getAttribute('data-product-id');
                                            const input = document.querySelector(`.quantity-input[data-product-id="${productId}"]`);
                                            let value = parseInt(input.value) || 1;
                                            if (value > 1) {
                                                input.value = value - 1;
                                            }
                                        });
                                    });

                                    // Prevent manual input from going below 1 or above max
                                    document.querySelectorAll('.quantity-input').forEach(input => {
                                        input.addEventListener('change', function() {
                                            const max = parseInt(this.getAttribute('max'));
                                            let value = parseInt(this.value) || 1;
                                            
                                            if (value < 1) {
                                                this.value = 1;
                                            } else if (value > max) {
                                                this.value = max;
                                            }
                                        });
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-600 mb-2">Tidak ada produk</h3>
                        <p class="text-gray-500 text-sm">Produk yang Anda cari tidak tersedia. Coba ubah filter atau cari kata kunci lain.</p>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="py-6 border-t border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-sm text-gray-600">
                            Menampilkan <span class="font-semibold">{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</span> dari <span class="font-semibold">{{ $products->total() }}</span> produk
                        </div>
                    </div>
                    <div class="flex justify-center">
                        {{ $products->links() }}
                    </div>
                </div>

                <!-- Mobile Bottom Navigation -->
                <div class="md:hidden bg-white border-t border-gray-200 fixed bottom-0 left-0 right-0 z-50 shadow-lg">
                    <div class="flex justify-around items-center h-16">
                        <a href="{{ route('dropshipper.dashboard') }}" class="flex flex-col items-center justify-center {{ request()->routeIs('dropshipper.dashboard') ? 'text-primary' : 'text-gray-700 hover:text-primary' }} transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span class="text-xs mt-1">Beranda</span>
                        </a>
                        <a href="{{ route('dropshipper.catalog') }}" class="flex flex-col items-center justify-center {{ request()->routeIs('dropshipper.catalog') ? 'text-primary' : 'text-gray-700 hover:text-primary' }} transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                            <span class="text-xs mt-1 {{ request()->routeIs('dropshipper.catalog') ? 'font-semibold' : '' }}">Produk</span>
                        </a>
                        <a href="{{ route('dropshipper.orders') }}" class="flex flex-col items-center justify-center {{ request()->routeIs('dropshipper.orders') ? 'text-primary' : 'text-gray-700 hover:text-primary' }} transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <span class="text-xs mt-1">Pesanan</span>
                        </a>
                        <a href="{{ route('dropshipper.cart') }}" class="flex flex-col items-center justify-center text-gray-700 hover:text-primary transition relative">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            @php
                                $cartItems = \App\Models\Order::where('user_id', auth()->id())->where('status', 'belum_dibayar')->with('items')->first();
                                $cartCount = $cartItems ? $cartItems->items->count() : 0;
                            @endphp
                            @if($cartCount > 0)
                            <span class="absolute -top-1 right-3 bg-primary text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-semibold">{{ $cartCount }}</span>
                            @endif
                            <span class="text-xs mt-1">Keranjang</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Add smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Add interactive hover effects
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>
