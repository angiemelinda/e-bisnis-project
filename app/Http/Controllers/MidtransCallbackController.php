<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request, Notification $notification)
    {
        $serverKey = config('midtrans.server_key');

        $signature = hash(
            'sha512',
            $notification->order_id .
            $notification->status_code .
            $notification->gross_amount .
            $serverKey
        );

        if ($signature !== $notification->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        $orderCode = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $paymentType = $notification->payment_type;
        $fraudStatus = $notification->fraud_status;

        $order = Order::where('order_code', $orderCode)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Create a transaction record for history (if payment exists attach it)
        $payment = $order->payment;

        try {
            \App\Models\Transaction::create([
                'order_id' => $order->id,
                'payment_id' => $payment ? $payment->id : null,
                'midtrans_order_id' => $orderCode,
                'transaction_id' => $notification->transaction_id ?? null,
                'amount' => $notification->gross_amount ?? $order->total,
                'payment_type' => $paymentType ?? null,
                'status' => $transactionStatus ?? null,
                'raw_response' => json_encode($notification),
            ]);
        } catch (\Exception $e) {
            // Do not block callback handling if transaction record fails
            // logger()->warning('Failed to create transaction record: '.$e->getMessage());
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
