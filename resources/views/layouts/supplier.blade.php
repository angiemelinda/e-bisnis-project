<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Supplier Grosir Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
<body class="bg-gray-100 font-inter min-h-screen flex">

<!-- Sidebar -->
<aside class="w-64 bg-white shadow-lg flex flex-col border-r">
    <div class="p-6 text-2xl font-bold text-orange-500 border-b">
        Grosir<span class="text-gray-800">Hub</span>
    </div>

    <div class="px-4 mt-6">
        <p class="text-xs font-semibold text-gray-400 uppercase mb-3">Menu Utama</p>
        <nav class="space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('supplier.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition
                {{ request()->routeIs('supplier.dashboard') ? 'bg-orange-100 text-orange-600 border-l-4 border-orange-500' : 'text-gray-700 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 10.5L12 3l9 7.5M5 10v10h5v-6h4v6h5V10"/>
                </svg>
                Dashboard
            </a>

            <!-- Produk -->
            <a href="{{ route('supplier.produk.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition
                {{ request()->routeIs('supplier.produk.*') ? 'bg-orange-100 text-orange-600 border-l-4 border-orange-500' : 'text-gray-700 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                    <path d="M3.3 7L12 12l8.7-5M12 22V12"/>
                </svg>
                Produk
            </a>

            <!-- Pesanan -->
            <a href="{{ route('supplier.pesanan.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition
                {{ request()->routeIs('supplier.pesanan.*') ? 'bg-orange-100 text-orange-600 border-l-4 border-orange-500' : 'text-gray-700 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path d="M6 2h12v20l-3-2-3 2-3-2-3 2V2z"/>
                    <path d="M9 6h6M9 10h6M9 14h4"/>
                </svg>
                Pesanan
            </a>

            <!-- Pendapatan -->
            <a href="{{ route('supplier.earnings') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition
                {{ request()->routeIs('supplier.earnings') ? 'bg-orange-100 text-orange-600 border-l-4 border-orange-500' : 'text-gray-700 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Pendapatan
            </a>
        </nav>

        <div class="my-6 border-t"></div>

        <p class="text-xs font-semibold text-gray-400 uppercase mt-8 mb-3">Pengaturan</p>
        <nav class="space-y-1">
            <!-- Profil -->
            <a href="{{ route('supplier.profil.edit') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition
                {{ request()->routeIs('supplier.profil.*') ? 'bg-orange-100 text-orange-600 border-l-4 border-orange-500' : 'text-gray-700 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 12a5 5 0 100-10 5 5 0 000 10z"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 20c0-4 4-6 8-6s8 2 8 6"/>
                </svg>
                Profil
            </a>

            <!-- Pengaturan -->
            <a href="{{ route('supplier.pengaturan') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition
                {{ request()->routeIs('supplier.pengaturan') ? 'bg-orange-100 text-orange-600 border-l-4 border-orange-500' : 'text-gray-700 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.591 1.066
                        1.724 1.724 0 012.356 2.356 1.724 1.724 0 001.066 2.591c1.756.426 1.756 2.924 0 3.35
                        a1.724 1.724 0 00-1.066 2.591 1.724 1.724 0 01-2.356 2.356
                        1.724 1.724 0 00-2.591 1.066c-.426 1.756-2.924 1.756-3.35 0
                        a1.724 1.724 0 00-2.591-1.066 1.724 1.724 0 01-2.356-2.356
                        1.724 1.724 0 00-1.066-2.591c-1.756-.426-1.756-2.924 0-3.35
                        a1.724 1.724 0 001.066-2.591 1.724 1.724 0 012.356-2.356
                        1.724 1.724 0 002.591-1.066z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Pengaturan
            </a>

            <!-- Logout -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-red-600 hover:bg-red-50 transition font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 12H9m0 0l3-3m-3 3l3 3" />
                    </svg>
                    Logout
                </button>
            </form>
        </nav>
    </div>
</aside>

<!-- Konten Utama -->
<main class="flex-1 p-6 max-w-7xl mx-auto space-y-6">

    <!-- HEADER GLOBAL (Hi, Search, Notif) -->
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
        <!-- Sapaan -->
        <div class="text-gray-800 font-semibold text-lg">
            Hi, {{ Auth::user()->name }}
        </div>

        <!-- Search Produk (Hanya di halaman Produk) -->
        @if(request()->routeIs('supplier.produk.*'))
        <form action="{{ route('supplier.produk.index') }}" method="GET" class="flex-1 max-w-md">
            <div class="relative flex items-center">
                <svg class="w-5 h-5 absolute left-3 text-gray-400" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35m0 0a7 7 0 10-9.9-9.9 7 7 0 009.9 9.9z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari produk..."
                    class="w-full pl-10 p-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-400 focus:outline-none">
            </div>
        </form>
        @endif

        <!-- Ikon Pesan & Notifikasi -->
        <div class="flex items-center gap-3">
            @php
                $unreadCount = \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->count();
                $notifications = \App\Models\Notification::where('user_id', auth()->id())->latest()->take(5)->get();
            @endphp
            <div class="relative group">
                <button class="p-2 rounded-lg bg-yellow-400 text-white hover:bg-yellow-500 relative">
                    <!-- Notifikasi Icon -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" 
                        viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    @if($unreadCount > 0)
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ $unreadCount }}</span>
                    @endif
                </button>
                <!-- Dropdown Notifikasi -->
                <div class="hidden group-hover:block absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl z-50 border border-gray-200">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="font-semibold text-gray-800">Notifikasi</h3>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        @forelse($notifications as $notification)
                        <a href="{{ $notification->link ?: '#' }}" 
                           class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100 {{ !$notification->is_read ? 'bg-orange-50' : '' }}"
                           onclick="markAsRead({{ $notification->id }})">
                            <div class="flex items-start gap-3">
                                <div class="shrink-0">
                                    @if($notification->type === 'order' || $notification->type === 'pesanan')
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                        </div>
                                    @elseif($notification->type === 'payment')
                                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-sm text-gray-900">{{ $notification->title }}</p>
                                    <p class="text-xs text-gray-600 mt-1 line-clamp-2">{{ $notification->message }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                                @if(!$notification->is_read)
                                <div class="shrink-0">
                                    <div class="w-2 h-2 bg-orange-500 rounded-full"></div>
                                </div>
                                @endif
                            </div>
                        </a>
                        @empty
                        <div class="px-4 py-8 text-center text-gray-500 text-sm">
                            Tidak ada notifikasi
                        </div>
                        @endforelse
                    </div>
                    @if($notifications->count() > 0)
                    <div class="p-3 border-t border-gray-200 text-center">
                        <a href="{{ route('supplier.notifications') }}" class="text-sm text-orange-600 hover:text-orange-700 font-medium">Lihat Semua</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Konten halaman --}}
    @yield('content')
</main>

@stack('scripts')

<script>
    function markAsRead(notificationId) {
        fetch(`/supplier/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(() => {
            // Reload page to update notification count
            setTimeout(() => location.reload(), 500);
        });
    }
</script>
</body>
</html>

