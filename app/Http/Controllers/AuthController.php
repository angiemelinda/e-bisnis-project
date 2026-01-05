<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showRegister()
    {
        // Jika sudah login, redirect ke dashboard sesuai role
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }
        
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'role' => ['required', 'in:supplier,dropshipper,super_admin,admin_produk,admin_pengguna,admin_transaksi,admin_laporan'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            Log::warning('Registration validation failed', [
                'errors' => $validator->errors()->toArray(),
                'input' => $request->except('password', 'password_confirmation'),
            ]);
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        // Log the registration attempt (no password)
        Log::info('Registration attempt', [
            'name' => $validated['name'] ?? null,
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'role' => $validated['role'] ?? null,
        ]);

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'role' => $validated['role'],
                'password' => Hash::make($validated['password']),
                'is_active' => true, // Aktifkan user baru secara default
                'email_verified_at' => now(), // Verifikasi email otomatis
            ]);
        } catch (\Exception $e) {
            Log::error('Registration failed', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Terjadi kesalahan pada server'])->withInput();
        }

        // Login user secara otomatis setelah registrasi
        Auth::login($user);
        
        // Regenerate session untuk keamanan
        $request->session()->regenerate();

        // Redirect ke dashboard sesuai role dengan pesan sukses
        return $this->redirectByRole($user->role)
            ->with('success', 'Registrasi berhasil! Selamat datang, ' . $user->name . '!');
    }

    public function showLogin()
    {
        // Jika sudah login, redirect ke dashboard sesuai role
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }
        
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Cek apakah user ada dan aktif
        $user = User::where('email', $credentials['email'])->first();
        
        if ($user && !$user->is_active) {
            return back()->withErrors(['email' => 'Akun Anda belum aktif. Silakan hubungi administrator.'])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $role = Auth::user()->role;
            
            // Log login success
            Log::info('User logged in', [
                'user_id' => Auth::id(),
                'email' => Auth::user()->email,
                'role' => $role
            ]);
            
            return $this->redirectByRole($role)
                ->with('success', 'Login berhasil! Selamat datang, ' . Auth::user()->name . '!');
        }

        return back()->withErrors(['email' => 'Email atau password salah'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    private function redirectByRole(string $role)
    {
        return match ($role) {
            'super_admin' => redirect()->route('superadmin.dashboard'),
            'admin_produk' => redirect()->route('adminproduk.dashboard'),
            'admin_pengguna' => redirect()->route('adminpengguna.dashboard'),
            'admin_transaksi' => redirect()->route('admintransaksi.dashboard'),
            'admin_laporan' => redirect()->route('adminlaporan.dashboard'),
            'supplier' => redirect()->route('supplier.dashboard'),
            'dropshipper' => redirect()->route('dropshipper.dashboard'),
            default => redirect()->route('home'),
        };
    }
}
