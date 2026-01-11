<?php

namespace App\Http\Controllers\Dropshipper;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

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
         * - with(['category', 'primaryImage']) → eager loading agar tidak N+1 query
         * - status active → hanya produk aktif
         */
        $topProducts = Product::with(['category', 'primaryImage'])
            ->where('status', 'active')
            ->orderBy('stock', 'desc')
            ->take(12)
            ->get();

        /**
         * Ambil produk terbaru
         * Digunakan untuk section "Produk Terbaru"
         */
        $newProducts = Product::with(['category', 'primaryImage'])
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
         * Ambil order status dari user yang sedang login
         */
        $userId = Auth::id();
        
        // Belum Bayar - payment_status = menunggu_pembayaran
        $pendingPayment = Order::where('user_id', $userId)
            ->where('payment_status', 'menunggu_pembayaran')
            ->count();
        
        // Dikemas - status = dikemas
        $packing = Order::where('user_id', $userId)
            ->where('status', 'dikemas')
            ->count();
        
        // Dikirim - status = dikirim
        $shipped = Order::where('user_id', $userId)
            ->where('status', 'dikirim')
            ->count();
        
        // Selesai - status = selesai
        $completed = Order::where('user_id', $userId)
            ->where('status', 'selesai')
            ->count();

        /**
         * Kirim semua data ke view dashboard
         * View TIDAK DIUBAH → aman untuk frontend
         */

        return view('dropshipper.dashboard', [
            'topProducts' => $topProducts,
            'newProducts' => $newProducts,
            'categories' => $categories,
            'pendingPayment' => $pendingPayment,
            'packing' => $packing,
            'shipped' => $shipped,
            'completed' => $completed
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
