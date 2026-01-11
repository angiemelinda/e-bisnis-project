<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Pesanan;
use App\Models\OrderItem;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
{
    $supplierId = Auth::id();
    
    // Get current month and previous month data
    $currentMonth = now()->month;
    $currentYear = now()->year;
    $lastMonth = $currentMonth == 1 ? 12 : $currentMonth - 1;
    $lastMonthYear = $currentMonth == 1 ? $currentYear - 1 : $currentYear;

    // Total products
    $totalProduk = Product::where('user_id', $supplierId)->count();
    
    // Total products from last month
    $totalProdukLastMonth = Product::where('user_id', $supplierId)
        ->whereMonth('created_at', $lastMonth)
        ->whereYear('created_at', $lastMonthYear)
        ->count();

    // Orders this month
    $ordersThisMonth = Pesanan::where('supplier_id', $supplierId)
        ->whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->count();

    // Total stock sold this month (simplified - you might need to adjust this based on your order items)
    $stokTerjual = 0; // Add your logic to calculate this

    // Other metrics
    $totalOrders = Pesanan::where('supplier_id', $supplierId)->count();
    $totalStok = Product::where('user_id', $supplierId)->sum('stock');
    $outOfStock = Product::where('user_id', $supplierId)->where('stock', 0)->count();

    // Recent orders
    $pesananTerbaru = Pesanan::where('supplier_id', $supplierId)
        ->latest()
        ->take(5)
        ->get()
        ->map(function($pesanan) {
            return (object)[
                'id' => $pesanan->id,
                'kode' => $pesanan->kode_pesanan,
                'status' => $pesanan->status,
                'total' => $pesanan->total_harga,
                'created_at' => $pesanan->created_at
            ];
        });

    // Top products by stock (lowest stock first)
    $produkTeratas = Product::with(['images' => function($query) {
            $query->where('is_primary', true);
        }])
        ->where('user_id', $supplierId)
        ->orderBy('stock', 'asc')
        ->take(5)
        ->get()
        ->map(function($produk) {
            $primaryImage = $produk->images->isNotEmpty() 
                ? (object)[
                    'path' => $produk->images->first()->path,
                    'url' => asset('storage/' . $produk->images->first()->path)
                  ]
                : null;

            return (object)[
                'id' => $produk->id,
                'name' => $produk->name,
                'stock' => $produk->stock,
                'status' => $produk->status,
                'harga_asli' => $produk->price * 1.1, // 10% markup
                'price' => $produk->price,
                'primaryImage' => $primaryImage,
                'gambar' => $primaryImage ? $primaryImage->url : 'https://via.placeholder.com/150'
            ];
        });

    // Notifications
    $notifikasi = collect();

    return view('supplier.dashboard2', compact(
        'totalProduk',
        'totalProdukLastMonth',
        'totalOrders',
        'ordersThisMonth',
        'stokTerjual',
        'totalStok',
        'outOfStock',
        'pesananTerbaru',
        'produkTeratas',
        'notifikasi'
    ));
}
}