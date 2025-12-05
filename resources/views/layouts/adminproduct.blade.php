<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-orange-600">Admin Panel</h1>
            </div>
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-6 rounded hover:bg-orange-100 hover:text-orange-600 transition mb-2 @if(request()->routeIs('admin.dashboard')) bg-orange-50 text-orange-600 font-semibold @endif">Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="block py-2.5 px-6 rounded hover:bg-orange-100 hover:text-orange-600 transition mb-2 @if(request()->routeIs('admin.products.*')) bg-orange-50 text-orange-600 font-semibold @endif">Daftar Produk</a>
                <a href="{{ route('admin.categories.index') }}" class="block py-2.5 px-6 rounded hover:bg-orange-100 hover:text-orange-600 transition mb-2 @if(request()->routeIs('admin.categories.*')) bg-orange-50 text-orange-600 font-semibold @endif">Kategori Produk</a>
                <a href="{{ route('admin.stock.index') }}" class="block py-2.5 px-6 rounded hover:bg-orange-100 hover:text-orange-600 transition mb-2 @if(request()->routeIs('admin.stock.*')) bg-orange-50 text-orange-600 font-semibold @endif">Stok</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            @yield('content')
        </main>

    </div>

    @stack('scripts')
</body>
</html>
