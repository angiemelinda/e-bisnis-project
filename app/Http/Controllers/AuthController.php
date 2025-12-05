<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'role' => ['required', 'in:supplier,dropshipper,super_admin,admin_produk,admin_pengguna,admin_transaksi,admin_laporan'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'password' => $validated['password'],
        ]);

        Auth::login($user);

        return $this->redirectByRole($user->role)->with('success', 'Registrasi berhasil!');
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

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $role = Auth::user()->role;
            return $this->redirectByRole($role)->with('success', 'Login berhasil!');
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
