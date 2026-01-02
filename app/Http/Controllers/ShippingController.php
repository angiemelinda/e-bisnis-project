<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Http;

class ShippingController extends Controller
{
    /**
     * ===============================
     * ADMIN & SUPPLIER
     * Update resi + kirim barang
     * ===============================
     */
    public function update(Request $request, Order $order)
    {
        // Hanya admin & supplier
        abort_if(!in_array(auth()->user()->role, ['admin', 'supplier']), 403);

        // Validasi status
        if ($order->status !== 'dikemas') {
            return response()->json([
                'message' => 'Order belum siap dikirim'
            ], 400);
        }

        $request->validate([
            'courier' => 'required|string|max:50',
            'resi' => 'required|string|max:100',
        ]);

        $order->update([
            'courier' => $request->courier,
            'resi' => $request->resi,
            'status' => 'dikirim',
        ]);

        return response()->json([
            'message' => 'Pengiriman berhasil diproses',
            'data' => $order
        ]);
    }

    /**
     * ===============================
     * DROPSHIPPER
     * Tracking pengiriman
     * ===============================
     */
    public function track(Request $request, $resi)
    {
        // Cari order milik dropshipper
        $order = Order::where('resi', $resi)
            ->where('user_id', auth()->id())
            ->first();

        if (!$order) {
            return response()->json([
                'message' => 'Resi tidak ditemukan'
            ], 404);
        }

        /**
         * OPTIONAL:
         * Jika pakai API ekspedisi (RajaOngkir / dll)
         */
        $providerUrl = config('services.shipping.url');
        $providerKey = config('services.shipping.key');

        if ($providerUrl) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => "Bearer {$providerKey}",
                ])->get($providerUrl . '/' . $resi);

                if ($response->successful()) {
                    return response()->json([
                        'source' => 'external',
                        'data' => $response->json()
                    ]);
                }
            } catch (\Exception $e) {
                // fallback ke data lokal
            }
        }

        // Fallback lokal
        return response()->json([
            'source' => 'local',
            'order_code' => $order->order_code,
            'status' => $order->status,
            'payment_status' => $order->payment_status,
            'courier' => $order->courier,
            'resi' => $order->resi,
        ]);
    }
}
