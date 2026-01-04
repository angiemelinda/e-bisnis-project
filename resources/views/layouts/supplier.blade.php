<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Supplier Grosir Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md flex-shrink-0">
            <div class="p-4 font-bold text-lg border-b">Supplier Hub</div>
            <nav class="p-4">
                <ul>
                    <li class="mb-2">
                        <a href="{{ route('supplier.dashboard') }}"
                           class="block py-2 px-4 rounded hover:bg-gray-200 {{ request()->routeIs('supplier.dashboard') ? 'bg-gray-200 font-semibold' : '' }}">
                           Dashboard
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('supplier.produk.index') }}"
                           class="block py-2 px-4 rounded hover:bg-gray-200 {{ request()->routeIs('supplier.produk.*') ? 'bg-gray-200 font-semibold' : '' }}">
                           Produk
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('supplier.pesanan.index') }}"
                           class="block py-2 px-4 rounded hover:bg-gray-200 {{ request()->routeIs('supplier.pesanan.*') ? 'bg-gray-200 font-semibold' : '' }}">
                           Pesanan
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('supplier.profile') }}"
                           class="block py-2 px-4 rounded hover:bg-gray-200 {{ request()->routeIs('supplier.profile') ? 'bg-gray-200 font-semibold' : '' }}">
                           Profil
                        </a>
                    </li>
                    <li class="mt-8">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left py-2 px-4 rounded hover:bg-gray-200">Logout</button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 overflow-auto">
            <h1 class="text-2xl font-bold mb-6">@yield('header')</h1>
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
