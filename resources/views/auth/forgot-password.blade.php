@extends('layouts.guest')

@section('title', 'Lupa Password - GrosirHub')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-md">
        <!-- Card -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <!-- Header -->
            <div class="text-center mb-6">
                <div class="inline-block bg-gradient-to-br from-primary to-secondary p-2.5 rounded-xl mb-3">
                    <i class="fas fa-key text-white text-xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-dark mb-1">Lupa Password</h2>
                <p class="text-sm text-gray-600">Masukkan email untuk reset password</p>
            </div>

            <!-- Form -->
            <form id="forgotPasswordForm" class="space-y-4" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5" for="email">
                        Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400 text-sm"></i>
                        </div>
                        <input 
                            type="email" 
                            id="email" name="email"
                            class="w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                            placeholder="nama@email.com"
                            required
                        >
                    </div>
                </div>

                <button 
                    type="submit"
                    class="w-full bg-gradient-to-r from-primary to-secondary text-white py-2.5 rounded-lg text-sm font-semibold hover:shadow-md transition">
                    Kirim Link Reset Password
                </button>
            </form>

            <!-- Back to Login -->
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm text-primary hover:text-secondary font-semibold">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

