<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - GrosirHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
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
                        'display': ['Plus Jakarta Sans', 'sans-serif'],
                        'body': ['Manrope', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Manrope', sans-serif;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Plus Jakarta Sans', sans-serif;
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

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
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

        .animate-slide-in-right {
            animation: slideInRight 0.4s ease-out;
        }

        /* Profile section stagger */
        .profile-section:nth-child(1) { animation-delay: 0s; }
        .profile-section:nth-child(2) { animation-delay: 0.1s; }
        .profile-section:nth-child(3) { animation-delay: 0.2s; }
        .profile-section:nth-child(4) { animation-delay: 0.3s; }

        /* Smooth transitions */
        * {
            transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
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

        /* Tab active state */
        .tab-button.active {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
            font-weight: 700;
        }

        .tab-button:not(.active):hover {
            background-color: #fff7ed;
            color: #f97316;
        }

        /* Input focus state */
        .profile-input:focus {
            border-color: #f97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        }

        /* Avatar upload hover */
        .avatar-upload-overlay {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .avatar-container:hover .avatar-upload-overlay {
            opacity: 1;
        }

        /* Save button pulse */
        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(249, 115, 22, 0.4);
            }
            50% {
                box-shadow: 0 0 30px rgba(249, 115, 22, 0.6);
            }
        }

        .save-button-active {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        /* List item hover */
        .list-item-hover {
            transition: all 0.2s ease;
        }

        .list-item-hover:hover {
            background: linear-gradient(to right, #fff7ed, transparent);
            border-left: 4px solid #f97316;
            padding-left: 20px;
        }

        /* Toggle switch */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 24px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e1;
            transition: .4s;
            border-radius: 24px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .toggle-slider {
            background-color: #f97316;
        }

        input:checked + .toggle-slider:before {
            transform: translateX(24px);
        }

        /* Profile completion bar */
        .progress-bar {
            position: relative;
            overflow: hidden;
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: var(--progress, 0%);
            background: linear-gradient(90deg, #f97316, #ea580c);
            transition: width 0.6s ease;
        }

        /* Section divider */
        .section-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e5e7eb, transparent);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Top Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('dropshipper.dashboard') }}" class="text-2xl font-bold text-primary font-display">GrosirHub</a>
                </div>

                <!-- Navigation Menu -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('dropshipper.dashboard') }}" class="text-gray-700 hover:text-primary font-medium">Beranda</a>
                    <a href="{{ route('dropshipper.catalog') }}" class="text-gray-700 hover:text-primary font-medium">Produk</a>
                    <a href="{{ route('dropshipper.orders') }}" class="text-gray-700 hover:text-primary font-medium">Pesanan</a>
                    <a href="{{ route('dropshipper.order-history') }}" class="text-gray-700 hover:text-primary font-medium">Riwayat</a>
                </div>

                <!-- Right Section -->
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
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </button>
                        <div class="hidden group-hover:block absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50 animate-slide-down">
                            <a href="{{ route('dropshipper.profile') }}" class="block px-4 py-2 text-sm text-primary font-semibold bg-orange-50">Profil Saya</a>
                            <hr class="my-1">
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-20 md:mb-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Navigation -->
            <aside class="lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-2xl shadow-sm p-6 animate-slide-up sticky top-24">
                    <!-- Profile Summary -->
                    <div class="text-center mb-6 pb-6 border-b border-gray-100">
                        <div class="avatar-container relative inline-block mb-4">
                            <div class="w-24 h-24 bg-gradient-to-br from-orange-400 to-pink-500 rounded-full flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                        </div>
                        <h2 class="font-bold text-xl text-gray-900 mb-1 font-display">{{ $user->name }}</h2>
                        <p class="text-gray-600 text-sm mb-3">{{ $user->email }}</p>
                        <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-orange-100 to-amber-100 text-orange-800 border border-orange-200">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Dropshipper
                        </div>
                    </div>

                    <!-- Navigation Menu -->
                    <nav class="space-y-1">
                        <button class="tab-button active w-full text-left px-4 py-3 rounded-xl font-semibold flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Informasi Pribadi
                        </button>
                        <button class="tab-button w-full text-left px-4 py-3 rounded-xl font-medium text-gray-700 flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Alamat Pengiriman
                        </button>
                        <button class="tab-button w-full text-left px-4 py-3 rounded-xl font-medium text-gray-700 flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            Metode Pembayaran
                        </button>
                        <button class="tab-button w-full text-left px-4 py-3 rounded-xl font-medium text-gray-700 flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            Notifikasi
                        </button>
                        <button class="tab-button w-full text-left px-4 py-3 rounded-xl font-medium text-gray-700 flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Keamanan & Privasi
                        </button>
                    </nav>
                </div>
            </aside>

            <!-- Main Profile Content -->
            <div class="flex-1">
                <!-- Profile Completion Banner -->
                <div class="bg-gradient-to-r from-orange-500 to-pink-500 rounded-2xl p-6 mb-6 text-white shadow-lg animate-slide-up">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="font-bold text-xl mb-1 font-display">Lengkapi Profil Anda</h3>
                            <p class="text-orange-50 text-sm">Dapatkan pengalaman belanja yang lebih baik</p>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold font-display">75%</div>
                            <div class="text-xs text-orange-100">Selesai</div>
                        </div>
                    </div>
                    <div class="progress-bar bg-white bg-opacity-20 rounded-full h-2 mb-3" style="--progress: 75%;"></div>
                    <div class="flex flex-wrap gap-2 text-sm">
                        <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full">✓ Foto profil</span>
                        <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full">✓ Informasi dasar</span>
                        <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full">✓ Alamat pengiriman</span>
                        <span class="bg-white bg-opacity-30 px-3 py-1 rounded-full">○ Nomor telepon</span>
                    </div>
                </div>

                <!-- Personal Information Section -->
                <div class="bg-white rounded-2xl shadow-sm p-8 mb-6 animate-slide-in-right profile-section">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 font-display">Informasi Pribadi</h2>
                    </div>

                    @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-xl">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('dropshipper.profile.update') }}" method="POST" id="profileForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="profile-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                <div class="relative">
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="profile-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none pr-12">
                                    @if($user->email_verified_at)
                                    <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-green-600">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                                <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+62 812-3456-7890" class="profile-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-primary text-white rounded-xl font-semibold hover:bg-primary-dark flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                    <!-- Change Password Section -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900 font-display mb-4">Ganti Password</h3>
                        <form action="{{ route('dropshipper.profile.password.update') }}" method="POST" id="passwordForm">
                            @csrf
                            @method('PUT')
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password Saat Ini</label>
                                    <input type="password" name="current_password" required class="profile-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
                                    <input type="password" name="new_password" required minlength="8" class="profile-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                                    <input type="password" name="new_password_confirmation" required minlength="8" class="profile-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none">
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end">
                                <button type="submit" class="px-6 py-2.5 bg-gray-700 text-white rounded-xl font-semibold hover:bg-gray-800 flex items-center gap-2">
                                    Ganti Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Shopping Preferences Section -->
                <div class="bg-white rounded-2xl shadow-sm p-8 mb-6 animate-slide-in-right profile-section">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 font-display">Preferensi Belanja</h2>
                    
                    <div class="space-y-5">
                        <div class="flex items-center justify-between py-4 border-b border-gray-100">
                            <div class="flex-1">
                                <div class="font-semibold text-gray-900 mb-1">Kategori Produk Favorit</div>
                                <div class="text-sm text-gray-600">Dapatkan rekomendasi produk yang sesuai</div>
                            </div>
                            <button class="text-primary hover:text-primary-dark font-semibold text-sm">Atur</button>
                        </div>
                        
                        <div class="flex items-center justify-between py-4 border-b border-gray-100">
                            <div class="flex-1">
                                <div class="font-semibold text-gray-900 mb-1">Notifikasi Promo & Diskon</div>
                                <div class="text-sm text-gray-600">Terima penawaran khusus melalui email</div>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" checked>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between py-4 border-b border-gray-100">
                            <div class="flex-1">
                                <div class="font-semibold text-gray-900 mb-1">Notifikasi Pesanan</div>
                                <div class="text-sm text-gray-600">Update status pesanan dan pengiriman</div>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" checked>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between py-4 border-b border-gray-100">
                            <div class="flex-1">
                                <div class="font-semibold text-gray-900 mb-1">Rekomendasi Produk</div>
                                <div class="text-sm text-gray-600">Saran produk berdasarkan riwayat belanja</div>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" checked>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between py-4">
                            <div class="flex-1">
                                <div class="font-semibold text-gray-900 mb-1">Newsletter Mingguan</div>
                                <div class="text-sm text-gray-600">Tips bisnis dan trend produk terbaru</div>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Saved Addresses Section -->
                <div class="bg-white rounded-2xl shadow-sm p-8 mb-6 animate-slide-in-right profile-section">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 font-display">Alamat Tersimpan</h2>
                        <button class="px-6 py-2.5 bg-primary text-white rounded-xl font-semibold hover:bg-primary-dark flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Alamat
                        </button>
                    </div>

                    <div class="space-y-4">
                        <!-- Address 1 -->
                        <div class="list-item-hover p-6 border-2 border-orange-200 rounded-2xl bg-gradient-to-r from-orange-50 to-transparent">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-pink-500 rounded-xl flex items-center justify-center text-white">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="font-bold text-gray-900">Rumah</span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-primary text-white">
                                                Utama
                                            </span>
                                        </div>
                                        <div class="text-sm text-gray-600">John Doe • +62 812-3456-7890</div>
                                    </div>
                                </div>
                                <button class="text-primary hover:text-primary-dark font-semibold text-sm">Edit</button>
                            </div>
                            <p class="text-gray-700 leading-relaxed">
                                Jl. Merdeka No. 123, RT 05/RW 08, Kelurahan Menteng, Kecamatan Menteng, Jakarta Pusat, DKI Jakarta 10310
                            </p>
                        </div>

                        <!-- Address 2 -->
                        <div class="list-item-hover p-6 border-2 border-gray-200 rounded-2xl hover:border-orange-200">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center text-gray-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 mb-1">Kantor</div>
                                        <div class="text-sm text-gray-600">John Doe • +62 812-3456-7890</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button class="text-primary hover:text-primary-dark font-semibold text-sm">Edit</button>
                                    <button class="text-gray-400 hover:text-red-600 text-sm">Hapus</button>
                                </div>
                            </div>
                            <p class="text-gray-700 leading-relaxed">
                                Gedung Plaza Indonesia, Tower 2 Lt. 15, Jl. MH Thamrin No. 28-30, Jakarta Pusat, DKI Jakarta 10350
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Account Activity Section -->
                <div class="bg-white rounded-2xl shadow-sm p-8 animate-slide-in-right profile-section">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 font-display">Aktivitas Akun</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="text-center p-6 bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl border border-orange-100">
                            <div class="w-14 h-14 bg-gradient-to-br from-orange-400 to-pink-500 rounded-xl mx-auto mb-3 flex items-center justify-center text-white">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                                </svg>
                            </div>
                            <div class="text-3xl font-bold text-gray-900 font-display mb-1">{{ $totalOrders }}</div>
                            <div class="text-sm text-gray-600">Total Pesanan</div>
                        </div>

                        <div class="text-center p-6 bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl border border-green-100">
                            <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl mx-auto mb-3 flex items-center justify-center text-white">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="text-2xl md:text-3xl font-bold text-gray-900 font-display mb-1">Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
                            <div class="text-sm text-gray-600">Total Belanja</div>
                        </div>

                        <div class="text-center p-6 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl border border-blue-100">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-xl mx-auto mb-3 flex items-center justify-center text-white">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="text-3xl font-bold text-gray-900 font-display mb-1">{{ number_format($totalProducts, 0, ',', '.') }}</div>
                            <div class="text-sm text-gray-600">Produk Dibeli</div>
                        </div>
                    </div>

                    <div class="section-divider mb-6"></div>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">Bergabung Sejak</div>
                                    <div class="text-sm text-gray-600">{{ $user->created_at->format('d F Y') }}</div>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500">{{ $user->created_at->diffForHumans() }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">Aktivitas Terakhir</div>
                                    <div class="text-sm text-gray-600">Login dari Jakarta</div>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500">2 jam yang lalu</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Mobile Bottom Navigation -->
    <div class="md:hidden bg-white border-t border-gray-200 fixed bottom-0 left-0 right-0 z-50 shadow-lg">
        <div class="flex justify-around items-center h-16">
            <a href="{{ route('dropshipper.dashboard') }}" class="flex flex-col items-center justify-center text-gray-700 hover:text-primary transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="text-xs mt-1">Beranda</span>
            </a>
            <a href="{{ route('dropshipper.catalog') }}" class="flex flex-col items-center justify-center text-gray-700 hover:text-primary transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                <span class="text-xs mt-1">Produk</span>
            </a>
            <a href="{{ route('dropshipper.orders') }}" class="flex flex-col items-center justify-center text-gray-700 hover:text-primary transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <span class="text-xs mt-1">Pesanan</span>
            </a>
            <a href="{{ route('dropshipper.profile') }}" class="flex flex-col items-center justify-center text-primary transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="text-xs mt-1 font-semibold">Profil</span>
            </a>
        </div>
    </div>

    <script>
        // Tab switching functionality
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.tab-button').forEach(btn => {
                    btn.classList.remove('active');
                });
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>