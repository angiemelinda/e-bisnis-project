<?php

namespace App\Http\Controllers\Dropshipper;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Models\Order;

class ReportController extends Controller
{
    use ApiResponse;

    /**
     * Summary report (totals, counts, estimated margin)
     */
    public function summary(Request $request)
    {
        $from = $request->query('from');
        $to = $request->query('to');

        $baseQuery = Order::where('user_id', auth()->id());

        if ($from) $baseQuery->whereDate('created_at', '>=', $from);
        if ($to) $baseQuery->whereDate('created_at', '<=', $to);

        $totalOrders = (clone $baseQuery)->count();
        $totalRevenue = (float) (clone $baseQuery)->sum('total');

        $estimatedPercent = config('reports.estimated_margin_percent', 0.10);

        $orders = $baseQuery->get();

        $totalEstimatedMargin = $orders->sum(function ($order) use ($estimatedPercent) {
            return ($order->margin && $order->margin > 0)
                ? $order->margin
                : ($order->total * $estimatedPercent);
        });

        return $this->success([
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue,
            'total_estimated_margin' => round($totalEstimatedMargin, 2),
            'by_status' => $orders->groupBy('status')->map->count(),
        ], 'Report summary');
    }

    /**
     * List orders with estimated margin column (paginated)
     */
    public function orders(Request $request)
    {
        $perPage = $request->integer('per_page', 15);
        $query = Order::with('items.product')->latest();

        if ($from = $request->query('from')) $query->whereDate('created_at', '>=', $from);
        if ($to = $request->query('to')) $query->whereDate('created_at', '<=', $to);

        $paginator = $query->paginate($perPage)->withQueryString();

        $estimatedPercent = config('reports.estimated_margin_percent', 0.10);

        $data = $paginator->through(function ($order) use ($estimatedPercent) {
            $estimatedMargin = ($order->margin && $order->margin > 0) ? $order->margin : round($order->total * $estimatedPercent, 2);

            return [
                'id' => $order->id,
                'order_code' => $order->order_code,
                'total' => $order->total,
                'status' => $order->status,
                'payment_status' => $order->payment_status,
                'estimated_margin' => $estimatedMargin,
                'items' => $order->items->map(function ($it) {
                    return [
                        'product_id' => $it->product_id,
                        'name' => optional($it->product)->name,
                        'quantity' => $it->quantity,
                        'price' => $it->price,
                    ];
                }),
            ];
        });

        return $this->paginated($data, null, 'Orders with estimated margin');
    }
}
