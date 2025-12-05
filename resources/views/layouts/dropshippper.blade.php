<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GrosirHub')</title>
    @vite('resources/css/app.css') <!-- Tailwind -->
</head>
<body class="bg-gray-50 flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md min-h-screen hidden md:block">
        <div class="p-6 text-2xl font-bold text-orange-500">GrosirHub</div>
        <nav class="mt-10">
            <a href="{{ route('dropshipper.dashboard') }}" class="block py-2.5 px-6 rounded hover:bg-orange-100 @if(request()->routeIs('dropshipper.dashboard')) bg-orange-100 font-semibold @endif">Dashboard</a>
            <a href="{{ route('dropshipper.catalog') }}" class="block py-2.5 px-6 rounded hover:bg-orange-100">Katalog Produk</a>
            <a href="{{ route('dropshipper.order-items') }}" class="block py-2.5 px-6 rounded hover:bg-orange-100">Order Barang</a>
            <a href="{{ route('dropshipper.order-history') }}" class="block py-2.5 px-6 rounded hover:bg-orange-100">Riwayat Order</a>
            <a href="{{ route('dropshipper.notifications') }}" class="block py-2.5 px-6 rounded hover:bg-orange-100">Notifikasi</a>
            <a href="{{ route('dropshipper.profile') }}" class="block py-2.5 px-6 rounded hover:bg-orange-100">Profil</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 p-6">
        <header class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-700">@yield('header', 'Dashboard')</h1>
            <div>
                <!-- Profil / Logout -->
            </div>
        </header>

        <main>
            @yield('content')
        </main>
    </div>

</body>
</html>
