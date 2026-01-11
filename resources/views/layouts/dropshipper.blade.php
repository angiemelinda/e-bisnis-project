<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GrosirHub')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="bg-white text-gray-900 min-h-screen font-inter">
    <div class="min-h-screen flex flex-col">
        <header class="sticky top-0 z-40 border-b border-gray-200 px-6 py-3 bg-white">
            <div class="relative flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('dropshipper.dashboard') }}" class="text-xl font-semibold text-gray-900">GrosirHub</a>
                </div>
                <nav class="absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 flex items-center gap-6">
                        <a href="{{ route('dropshipper.dashboard') }}" class="pb-2 flex items-center gap-2 {{ request()->routeIs('dropshipper.dashboard') ? 'text-orange-600 border-b-2 border-orange-600' : 'text-gray-700 hover:text-orange-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 3l9 8h-3v9H6v-9H3z"/></svg>
                            <span>Beranda</span>
                        </a>
                        <a href="{{ route('dropshipper.catalog') }}" class="pb-2 flex items-center gap-2 {{ request()->routeIs('dropshipper.catalog') ? 'text-orange-600 border-b-2 border-orange-600' : 'text-gray-700 hover:text-orange-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M4 6h16v4H4zM4 12h16v6H4z"/></svg>
                            <span>Produk</span>
                        </a>
                        <a href="{{ route('dropshipper.orders') }}" class="pb-2 flex items-center gap-2 {{ request()->routeIs('dropshipper.orders') ? 'text-orange-600 border-b-2 border-orange-600' : 'text-gray-700 hover:text-orange-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M3 3h2l.4 2H21l-2 9H7l-2-9H3zM7 18a2 2 0 104 0 2 2 0 00-4 0zm8 0a2 2 0 104 0 2 2 0 00-4 0z"/></svg>
                            <span>Pesanan</span>
                        </a>
                        <a href="{{ route('dropshipper.order-history') }}" class="pb-2 flex items-center gap-2 {{ request()->routeIs('dropshipper.order-history') ? 'text-orange-600 border-b-2 border-orange-600' : 'text-gray-700 hover:text-orange-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M13 3a9 9 0 109 9h-2a7 7 0 11-7-7V3zm1 5h-2v5l4 2 .9-1.8-2.9-1.2V8z"/></svg>
                            <span>Riwayat</span>
                        </a>
                        <a href="{{ route('dropshipper.profile') }}" class="pb-2 flex items-center gap-2 {{ request()->routeIs('dropshipper.profile') ? 'text-orange-600 border-b-2 border-orange-600' : 'text-gray-700 hover:text-orange-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 100-10 5 5 0 000 10zm0 2c-4 0-8 2-8 5v3h16v-3c0-3-4-5-8-5z"/></svg>
                            <span>Profil</span>
                        </a>
                </nav>
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('dropshipper.cart') }}" class="relative p-2 rounded-lg hover:bg-gray-100" title="Keranjang">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m12-9l2 9M9 21h6"/>
                        </svg>
                        <span id="cart-count" class="absolute -top-1 -right-1 text-xs px-1.5 py-0.5 rounded-full bg-orange-500 text-white hidden"></span>
                    </a>
                    @php
                        $unreadCount = \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->count();
                        $notifications = \App\Models\Notification::where('user_id', auth()->id())->latest()->take(5)->get();
                    @endphp
                    <div class="relative group">
                        <button class="p-2 rounded-lg hover:bg-gray-100 relative" title="Notifikasi">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22a2 2 0 002-2H10a2 2 0 002 2zm6-6V9a6 6 0 10-12 0v7l-2 2h16l-2-2z"/></svg>
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
                                <a href="{{ route('dropshipper.notifications') }}" class="text-sm text-orange-600 hover:text-orange-700 font-medium">Lihat Semua</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="px-4 py-2 rounded-lg bg-orange-500 text-white hover:bg-orange-600">Logout</button>
                    </form>
                </div>
            </div>
        </header>
        <main class="p-6">
            @yield('content')
            <div id="gh-toast" class="fixed bottom-6 left-1/2 -translate-x-1/2 -translate-y-4 opacity-0 transition-all duration-300 bg-gray-900 text-white text-sm px-4 py-2 rounded-lg shadow">Produk ditambahkan ke keranjang</div>
        </main>
        @stack('scripts')
    </div>

<script>
    function markAsRead(notificationId) {
        fetch(`/dropshipper/notifications/${notificationId}/read`, {
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
