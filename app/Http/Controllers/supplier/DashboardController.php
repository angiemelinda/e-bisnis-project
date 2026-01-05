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
        
        // Get real data
        $totalProduk = Product::where('user_id', $supplierId)->count();
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
        
        // Top products by stock (lowest stock first - need attention)
        $produkTeratas = Product::where('user_id', $supplierId)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get()
            ->map(function($produk) {
                return (object)[
                    'id' => $produk->id,
                    'nama' => $produk->name,
                    'stok' => $produk->stock,
                    'status' => $produk->status
                ];
            });
        
        // Notifications
        $notifikasi = collect();
        
        // New orders
        $newOrders = Pesanan::where('supplier_id', $supplierId)
            ->where('status', 'baru')
            ->latest()
            ->take(3)
            ->get();
        
        foreach ($newOrders as $order) {
            $notifikasi->push((object)[
                'message' => 'Pesanan baru masuk #' . $order->kode_pesanan,
                'type' => 'order',
                'id' => $order->id
            ]);
        }
        
        // Low stock products
        $lowStockProducts = Product::where('user_id', $supplierId)
            ->where('stock', '<', 10)
            ->where('stock', '>', 0)
            ->take(3)
            ->get();
        
        foreach ($lowStockProducts as $product) {
            $notifikasi->push((object)[
                'message' => 'Produk ' . $product->name . ' hampir habis (Stok: ' . $product->stock . ')',
                'type' => 'stock',
                'id' => $product->id
            ]);
        }
        
        // Out of stock
        $outOfStockProducts = Product::where('user_id', $supplierId)
            ->where('stock', 0)
            ->take(2)
            ->get();
        
        foreach ($outOfStockProducts as $product) {
            $notifikasi->push((object)[
                'message' => 'Produk ' . $product->name . ' stok habis',
                'type' => 'out_of_stock',
                'id' => $product->id
            ]);
        }
        
        return view('supplier.dashboard2', compact(
            'totalProduk',
            'totalOrders',
            'totalStok',
            'outOfStock',
            'pesananTerbaru',
            'produkTeratas',
            'notifikasi'
        ));
    }
}

