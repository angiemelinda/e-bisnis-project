<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EarningsController extends Controller
{
    public function index()
    {
        $supplierId = Auth::id();
        
        // Get completed orders (pesanan)
        $completedPesanan = Pesanan::where('supplier_id', $supplierId)
            ->where('status', 'selesai')
            ->get();
        
        $totalEarnings = $completedPesanan->sum('total_harga');
        
        // Get orders from OrderItem where product belongs to supplier
        $supplierProducts = Product::where('user_id', $supplierId)->pluck('id');
        
        $orderItems = OrderItem::whereIn('product_id', $supplierProducts)
            ->with(['order', 'product'])
            ->whereHas('order', function($query) {
                $query->where('payment_status', 'sudah_dibayar');
            })
            ->get();
        
        // Calculate total from order items (use subtotal if exists, otherwise calculate)
        $totalFromOrders = $orderItems->sum(function($item) {
            return $item->subtotal ?? ($item->price * $item->quantity);
        });
        
        // Monthly earnings
        $monthlyEarnings = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();
            
            $pesananMonthly = Pesanan::where('supplier_id', $supplierId)
                ->where('status', 'selesai')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('total_harga');
            
            $ordersMonthlyItems = OrderItem::whereIn('product_id', $supplierProducts)
                ->with(['order', 'product'])
                ->whereHas('order', function($query) use ($monthStart, $monthEnd) {
                    $query->where('payment_status', 'sudah_dibayar')
                          ->whereBetween('created_at', [$monthStart, $monthEnd]);
                })
                ->get();
            
            $ordersMonthly = $ordersMonthlyItems->sum(function($item) {
                return $item->subtotal ?? ($item->price * $item->quantity);
            });
            
            $monthlyEarnings[] = [
                'month' => $month->format('M Y'),
                'total' => $pesananMonthly + $ordersMonthly
            ];
        }
        
        // Recent transactions
        $recentTransactions = collect();
        
        // From Pesanan
        foreach ($completedPesanan->take(10) as $pesanan) {
            $recentTransactions->push([
                'type' => 'pesanan',
                'code' => $pesanan->kode_pesanan,
                'amount' => $pesanan->total_harga,
                'date' => $pesanan->created_at,
                'status' => $pesanan->status
            ]);
        }
        
        // From Orders
        foreach ($orderItems->take(10) as $item) {
            if ($item->order) {
                $recentTransactions->push([
                    'type' => 'order',
                    'code' => $item->order->order_code,
                    'amount' => $item->subtotal,
                    'date' => $item->order->created_at,
                    'status' => $item->order->payment_status
                ]);
            }
        }
        
        $recentTransactions = $recentTransactions->sortByDesc('date')->take(10);
        
        $totalEarningsAll = $totalEarnings + $totalFromOrders;
        
        return view('supplier.earnings', compact(
            'totalEarningsAll',
            'totalEarnings',
            'totalFromOrders',
            'monthlyEarnings',
            'recentTransactions'
        ));
    }
}



