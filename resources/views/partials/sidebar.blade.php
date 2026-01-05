@php
    $user = auth()->user();
    $role = $user->role ?? 'guest';
@endphp

@if(auth()->check())

<aside class="w-64 bg-white shadow-lg h-screen fixed left-0 top-0 overflow-y-auto z-50">
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center space-x-3">
            <div class="bg-gradient-to-r from-primary to-secondary p-2 rounded-lg">
                <i class="fas fa-box-open text-white text-xl"></i>
            </div>
            <span class="text-xl font-bold text-dark">Grosir<span class="text-primary">Hub</span></span>
        </div>
    </div>
    <nav class="p-4">
        @if($role === 'super_admin')
            <a href="{{ route('superadmin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('superadmin.dashboard') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-home w-5"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('superadmin.users') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('superadmin.users') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-users w-5"></i>
                <span>Pengguna</span>
            </a>
            <a href="{{ route('superadmin.suppliers') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('superadmin.suppliers') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-truck w-5"></i>
                <span>Supplier</span>
            </a>
            <a href="{{ route('superadmin.dropshippers') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('superadmin.dropshippers') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-handshake w-5"></i>
                <span>Dropshipper</span>
            </a>
            <a href="{{ route('superadmin.products') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('superadmin.products') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-box w-5"></i>
                <span>Produk</span>
            </a>
            <a href="{{ route('superadmin.transactions') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('superadmin.transactions') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-shopping-cart w-5"></i>
                <span>Transaksi</span>
            </a>
            <a href="{{ route('superadmin.reports') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('superadmin.reports') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-chart-bar w-5"></i>
                <span>Laporan</span>
            </a>
        @elseif($role === 'adminproduk')
            <a href="{{ route('adminproduk.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('adminproduk.dashboard') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-home w-5"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('adminproduk.products') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('adminproduk.products') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-box w-5"></i>
                <span>Daftar Produk</span>
            </a>
            <a href="{{ route('adminproduk.categories') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('adminproduk.categories') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-tags w-5"></i>
                <span>Kategori Produk</span>
            </a>
            <a href="{{ route('adminproduk.stock') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('adminproduk.stock') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-warehouse w-5"></i>
                <span>Stok</span>
            </a>
            <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 text-gray-700 hover:bg-gray-50 transition">
                <i class="fas fa-chart-line w-5"></i>
                <span>Laporan Produk</span>
            </a>
        @elseif($role === 'adminpengguna')
            <a href="{{ route('adminpengguna.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('adminpengguna.*') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-home w-5"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('adminpengguna.suppliers') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('adminpengguna.suppliers') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-truck w-5"></i>
                <span>Supplier</span>
            </a>
            <a href="{{ route('adminpengguna.dropshippers') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('adminpengguna.dropshippers') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-handshake w-5"></i>
                <span>Dropshipper</span>
            </a>
        @elseif($role === 'admintransaksi')
            <a href="{{ route('admintransaksi.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('admintransaksi.*') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-home w-5"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admintransaksi.all-transactions') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('admintransaksi.all-transactions') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-shopping-cart w-5"></i>
                <span>Semua Transaksi</span>
            </a>
            <a href="{{ route('admintransaksi.confirmation') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('admintransaksi.confirmation') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-check-circle w-5"></i>
                <span>Konfirmasi</span>
            </a>
        @elseif($role === 'adminlaporan')
            <a href="{{ route('adminlaporan.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('adminlaporan.*') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-home w-5"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('adminlaporan.sales-report') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('adminlaporan.sales-report') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-chart-bar w-5"></i>
                <span>Laporan Penjualan</span>
            </a>
            <a href="{{ route('adminlaporan.supplier-report') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('adminlaporan.supplier-report') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-file-alt w-5"></i>
                <span>Laporan Supplier</span>
            </a>
        @elseif($role === 'supplier')
            <a href="{{ route('supplier.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('supplier.*') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-home w-5"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('supplier.my-products') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('supplier.my-products') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-box w-5"></i>
                <span>Produk Saya</span>
            </a>
            <a href="{{ route('supplier.orders') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('supplier.orders') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-shopping-cart w-5"></i>
                <span>Pesanan</span>
            </a>
            <a href="{{ route('supplier.earnings') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('supplier.earnings') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-money-bill-wave w-5"></i>
                <span>Pendapatan</span>
            </a>
        @elseif($role === 'dropshipper')
            <a href="{{ route('dropshipper.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('dropshipper.*') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-home w-5"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('dropshipper.catalog') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('dropshipper.catalog') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-th w-5"></i>
                <span>Katalog</span>
            </a>
            <a href="{{ route('dropshipper.order-items') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('dropshipper.order-items') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-shopping-bag w-5"></i>
                <span>Item Pesanan</span>
            </a>
            <a href="{{ route('dropshipper.order-history') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('dropshipper.order-history') ? 'bg-orange-50 text-primary font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-history w-5"></i>
                <span>Riwayat Pesanan</span>
            </a>
        @endif
    </nav>
</aside>

@endif
