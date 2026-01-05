<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SuperAdminController extends Controller
{
    /**
     * Display dashboard with statistics
     */
    public function dashboard()
    {
        // Get data for current month
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        // Total Orders
        $totalOrders = Order::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
        
        // Orders last month for comparison
        $lastMonth = Carbon::now()->subMonth()->month;
        $lastYear = Carbon::now()->subMonth()->year;
        $totalOrdersLastMonth = Order::whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $lastYear)
            ->count();
        
        $ordersGrowth = $totalOrdersLastMonth > 0 
            ? (($totalOrders - $totalOrdersLastMonth) / $totalOrdersLastMonth) * 100 
            : 0;
        
        // Payment Success
        $paidOrders = Order::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->where('payment_status', 'paid')
            ->count();
        
        $pendingPayment = Order::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->where('payment_status', 'pending')
            ->count();
        
        $paymentSuccessRate = $totalOrders > 0 ? ($paidOrders / $totalOrders) * 100 : 0;
        
        // Total Transactions (Revenue)
        $totalRevenue = Order::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->where('payment_status', 'paid')
            ->sum('total');
        
        $revenueLastMonth = Order::whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $lastYear)
            ->where('payment_status', 'paid')
            ->sum('total');
        
        $revenueGrowth = $revenueLastMonth > 0 
            ? (($totalRevenue - $revenueLastMonth) / $revenueLastMonth) * 100 
            : 0;
        
        // Platform Fees (assuming 5% fee)
        $platformFeeRate = 0.05;
        $platformFees = $totalRevenue * $platformFeeRate;
        
        // Transaction trend for last 7 days
        $trendData = [];
        $trendLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dayRevenue = Order::whereDate('created_at', $date)
                ->where('payment_status', 'paid')
                ->sum('total');
            $trendData[] = $dayRevenue / 1000000; // Convert to millions
            $trendLabels[] = $date->format('D');
        }
        
        // Payment status distribution
        $paidCount = Order::where('payment_status', 'paid')->count();
        $pendingCount = Order::where('payment_status', 'pending')->count();
        $failedCount = Order::where('payment_status', 'failed')->count();
        $totalPaymentStatus = $paidCount + $pendingCount + $failedCount;
        
        $paymentDistribution = [
            'paid' => $totalPaymentStatus > 0 ? ($paidCount / $totalPaymentStatus) * 100 : 0,
            'pending' => $totalPaymentStatus > 0 ? ($pendingCount / $totalPaymentStatus) * 100 : 0,
            'failed' => $totalPaymentStatus > 0 ? ($failedCount / $totalPaymentStatus) * 100 : 0,
        ];
        
        // Recent Activities (latest orders)
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        $recentActivities = $recentOrders->map(function ($order) {
            return [
                'type' => 'order',
                'message' => 'Order #' . $order->order_code . ' ' . ($order->payment_status === 'paid' ? 'berhasil dibayar' : 'baru'),
                'detail' => ($order->user ? $order->user->name : 'Unknown') . ' - Rp ' . number_format($order->total, 0, ',', '.'),
                'time' => $order->created_at->diffForHumans(),
                'icon' => $order->payment_status === 'paid' ? 'check' : 'order',
            ];
        });
        
        // Add new user registrations
        $recentUsers = User::where('role', '!=', 'super_admin')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        foreach ($recentUsers as $user) {
            $recentActivities->push([
                'type' => 'user',
                'message' => 'User baru terdaftar',
                'detail' => $user->name . ' bergabung sebagai ' . $user->role,
                'time' => $user->created_at->diffForHumans(),
                'icon' => 'user',
            ]);
        }
        
        // Sort by created_at and take latest 5
        $recentActivities = $recentActivities->sortByDesc(function ($activity) {
            return $activity['time'];
        })->take(5)->values();
        
        return view('superadmin.dashboard', compact(
            'totalOrders',
            'ordersGrowth',
            'paidOrders',
            'pendingPayment',
            'paymentSuccessRate',
            'totalRevenue',
            'revenueGrowth',
            'platformFees',
            'trendData',
            'trendLabels',
            'paymentDistribution',
            'recentActivities'
        ));
    }
    
    /**
     * Display suppliers list
     */
    public function suppliers()
    {
        $suppliers = User::where('role', 'supplier')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('superadmin.suppliers', compact('suppliers'));
    }
    
    /**
     * Display dropshippers list
     */
    public function dropshippers()
    {
        $dropshippers = User::where('role', 'dropshipper')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('superadmin.dropshippers', compact('dropshippers'));
    }
    
    /**
     * Display transactions list
     */
    public function transactions()
    {
        $transactions = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('superadmin.transactions', compact('transactions'));
    }
    
    /**
     * Display reports
     */
    public function reports(Request $request)
    {
        $fromDate = $request->get('from') ? Carbon::parse($request->get('from')) : Carbon::now()->subMonth();
        $toDate = $request->get('to') ? Carbon::parse($request->get('to')) : Carbon::now();
        
        // Total Products Sold
        $totalProductsSold = OrderItem::whereHas('order', function ($query) use ($fromDate, $toDate) {
            $query->whereBetween('created_at', [$fromDate, $toDate])
                ->where('payment_status', 'paid');
        })->sum('quantity');
        
        // Total Transactions
        $totalTransactions = Order::whereBetween('created_at', [$fromDate, $toDate])
            ->where('payment_status', 'paid')
            ->count();
        
        // Total Revenue
        $totalRevenue = Order::whereBetween('created_at', [$fromDate, $toDate])
            ->where('payment_status', 'paid')
            ->sum('total');
        
        // Active Dropshippers
        $activeDropshippers = User::where('role', 'dropshipper')
            ->whereHas('orders', function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('created_at', [$fromDate, $toDate]);
            })
            ->distinct()
            ->count();
        
        // Report Data by Date
        $reportData = Order::select(
            DB::raw('DATE(orders.created_at) as date'),
            DB::raw('COUNT(DISTINCT orders.id) as transactions_count'),
            DB::raw('SUM(orders.total) as revenue')
        )
        ->whereBetween('orders.created_at', [$fromDate, $toDate])
        ->where('orders.payment_status', 'paid')
        ->groupBy(DB::raw('DATE(orders.created_at)'))
        ->orderBy('date', 'desc')
        ->get();
        
        // Get products sold per date
        $productsSoldData = OrderItem::select(
            DB::raw('DATE(orders.created_at) as date'),
            DB::raw('SUM(order_items.quantity) as products_sold')
        )
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->whereBetween('orders.created_at', [$fromDate, $toDate])
        ->where('orders.payment_status', 'paid')
        ->groupBy(DB::raw('DATE(orders.created_at)'))
        ->pluck('products_sold', 'date');
        
        // Format report data
        $formattedReportData = $reportData->map(function ($item) use ($productsSoldData) {
            $order = Order::whereDate('created_at', $item->date)->with('user')->first();
            return (object) [
                'date' => Carbon::parse($item->date)->format('Y-m-d'),
                'dropshipper_name' => $order && $order->user ? $order->user->name : 'Multiple',
                'products_sold' => $productsSoldData[$item->date] ?? 0,
                'transactions_count' => $item->transactions_count ?? 0,
                'revenue' => $item->revenue ?? 0,
            ];
        });
        
        // Manual pagination
        $currentPage = request()->get('page', 1);
        $perPage = 15;
        $currentItems = $formattedReportData->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $reportData = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentItems,
            $formattedReportData->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        return view('superadmin.reports', compact(
            'totalProductsSold',
            'totalTransactions',
            'totalRevenue',
            'activeDropshippers',
            'reportData',
            'fromDate',
            'toDate'
        ));
    }
}
