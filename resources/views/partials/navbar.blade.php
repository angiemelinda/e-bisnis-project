@php
    $isAdminPage = request()->routeIs('superadmin.*') || 
                   request()->routeIs('adminproduk.*') || 
                   request()->routeIs('adminpengguna.*') || 
                   request()->routeIs('admintransaksi.*') || 
                   request()->routeIs('adminlaporan.*') || 
                   request()->routeIs('supplier.*') || 
                   request()->routeIs('dropshipper.*');
@endphp

@if(auth()->check() && $isAdminPage)
    {{-- Navbar untuk halaman admin yang sudah login --}}
    <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-3">
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                    </div>
                    <div class="w-10 h-10 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-sm text-gray-600 hover:text-primary transition">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </header>
@elseif(!auth()->check())
    {{-- Navbar untuk halaman publik (guest) --}}
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <div class="bg-gradient-to-r from-primary to-secondary p-2 rounded-lg">
                        <i class="fas fa-box-open text-white text-2xl"></i>
                    </div>
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-dark">Grosir<span class="text-primary">Hub</span></a>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary transition">Beranda</a>
                    <a href="{{ route('product') }}" class="text-gray-700 hover:text-primary transition">Produk</a>
                    <a href="{{ route('supplier') }}" class="text-gray-700 hover:text-primary transition">Supplier</a>
                    <a href="{{ route('cara_kerja') }}" class="text-gray-700 hover:text-primary transition">Cara Kerja</a>
                    <a href="{{ route('kontak') }}" class="text-gray-700 hover:text-primary transition">Kontak</a>
                </div>

                <div class="flex items-center space-x-4">
                    <button class="text-gray-700 hover:text-primary transition">
                        <i class="fas fa-search text-xl"></i>
                    </button>
                    @if(!auth()->check())
                        <a href="{{ route('login') }}" class="bg-white border-2 border-primary text-primary px-6 py-2 rounded-lg hover:bg-primary hover:text-white transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-primary to-secondary text-white px-6 py-2 rounded-lg hover:shadow-lg transition">
                            Daftar
                        </a>
                    @else
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary transition">
                            {{ auth()->user()->name }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-white border-2 border-primary text-primary px-6 py-2 rounded-lg hover:bg-primary hover:text-white transition">
                                Logout
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </nav>
@endif
