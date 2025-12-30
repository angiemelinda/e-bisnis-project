<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        $notification = new Notification();

        $orderCode = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $paymentType = $notification->payment_type;
        $fraudStatus = $notification->fraud_status;

        $order = Order::where('order_code', $orderCode)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // ===== STATUS LOGIC =====
        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $order->update([
                'payment_status' => 'sudah_dibayar',
                'status' => 'dikemas',
            ]);
        }

        if ($transactionStatus == 'pending') {
            $order->update([
                'payment_status' => 'menunggu_pembayaran',
            ]);
        }

        if (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $order->update([
                'payment_status' => 'menunggu_pembayaran',
            ]);
        }

        return response()->json(['message' => 'Callback success']);
    }
}
