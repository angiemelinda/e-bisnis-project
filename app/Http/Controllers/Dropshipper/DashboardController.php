<?php

namespace App\Http\Controllers\Dropshipper;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dropshipper
     * Sprint 1: masih menampilkan data produk & kategori
     */
    public function index()
    {
        /**
         * Ambil produk dengan stok terbanyak
         * - with('category') → eager loading agar tidak N+1 query
         * - status active → hanya produk aktif
         */
        $topProducts = Product::with('category')
            ->where('status', 'active')
            ->orderBy('stock', 'desc')
            ->take(12)
            ->get();

        /**
         * Ambil produk terbaru
         * Digunakan untuk section "Produk Terbaru"
         */
        $newProducts = Product::with('category')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->take(12)
            ->get();

        /**
         * Ambil beberapa kategori untuk ditampilkan di dashboard
         */
        $categories = Category::orderBy('name')
            ->take(8)
            ->get();

        /**
         * Kirim semua data ke view dashboard
         * View TIDAK DIUBAH → aman untuk frontend
         */

        return view('dropshipper.dashboard', [
            'topProducts' => $topProducts,
            'newProducts' => $newProducts,
            'categories' => $categories
        ]);
    }

    public function profile()
    {
        return view('dropshipper.profile');
    }

    public function tracking()
    {
        return view('dropshipper.tracking');
    }

    public function reports()
    {
        return view('dropshipper.reports');
    }
}
