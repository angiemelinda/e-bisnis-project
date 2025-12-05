<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function index()
    {
        // Jika user sudah login, redirect ke dashboard sesuai role
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        return view('landing.index');
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
            default => view('landing.index'),
        };
    }
}

