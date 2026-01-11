<?php

namespace App\Http\Controllers\Dropshipper;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Models\Order;

class ShippingController extends Controller
{
    use ApiResponse;

    /**
     * Track order by resi (tracking number)
     * Returns JSON response with tracking information
     */
    public function track($resi)
    {
        $order = Order::where('resi', $resi)
            ->where('user_id', auth()->id())
            ->first();

        if (!$order) {
            return $this->error('Order tidak ditemukan atau resi tidak valid', 404);
        }

        // Basic tracking info
        // In production, you might want to integrate with shipping providers
        // like JNE, J&T, SiCepat, etc.
        $trackingInfo = [
            'resi' => $order->resi,
            'order_code' => $order->order_code,
            'courier' => $order->courier ?? 'Belum ditentukan',
            'status' => $order->status,
            'shipped_at' => $order->updated_at?->format('Y-m-d H:i:s'),
            'estimated_delivery' => $order->updated_at?->addDays(3)->format('Y-m-d'),
            'current_location' => 'Dalam perjalanan',
            'history' => [
                [
                    'date' => $order->created_at->format('Y-m-d H:i:s'),
                    'status' => 'Pesanan dibuat',
                    'location' => 'Gudang',
                ],
                [
                    'date' => $order->updated_at->format('Y-m-d H:i:s'),
                    'status' => ucfirst($order->status),
                    'location' => 'Dalam pengiriman',
                ],
            ],
        ];

        return $this->success($trackingInfo, 'Tracking information');
    }
}
