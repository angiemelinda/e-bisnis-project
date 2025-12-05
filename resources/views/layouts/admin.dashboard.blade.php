<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') • GrosirHub</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-body">
    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="brand">
                <span class="brand-logo">GH</span>
                <span class="brand-name">GrosirHub</span>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('admin.products') }}" class="nav-link {{ request()->routeIs('admin.products') ? 'active' : '' }}">Produk</a>
                <a href="{{ route('admin.categories') }}" class="nav-link {{ request()->routeIs('admin.categories') ? 'active' : '' }}">Kategori</a>
                <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">Pengguna</a>
                <a href="{{ route('admin.transactions') }}" class="nav-link {{ request()->routeIs('admin.transactions') ? 'active' : '' }}">Transaksi</a>
                <a href="{{ route('admin.suppliers') }}" class="nav-link {{ request()->routeIs('admin.suppliers') ? 'active' : '' }}">Supplier</a>
                <a href="{{ route('admin.dropshippers') }}" class="nav-link {{ request()->routeIs('admin.dropshippers') ? 'active' : '' }}">Dropshipper</a>
            </nav>
        </aside>
        <main class="admin-main">
            <header class="admin-header">
                <h1 class="page-title">@yield('title')</h1>
                <div class="header-actions">
                    <button class="btn btn-orange">Tambah Data</button>
                </div>
            </header>
            <section class="admin-content">
                @yield('content')
            </section>
            <footer class="admin-footer">
                <span>© {{ date('Y') }} GrosirHub. Super Admin Panel.</span>
            </footer>
        </main>
    </div>
</body>
</html>