<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        // Log incoming callback request
        \Log::info('Midtrans callback received', [
            'method' => $request->method(),
            'headers' => $request->headers->all(),
            'body' => $request->all(),
        ]);

        // Set Midtrans Config
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);

        try {
            // Create notification instance from request body
            $notification = new Notification();

            // Verify signature
            $serverKey = config('midtrans.server_key');
            
            if (empty($serverKey)) {
                \Log::error('Midtrans callback: Server key not configured');
                return response()->json(['message' => 'Server key not configured'], 500);
            }

            $signature = hash(
                'sha512',
                $notification->order_id .
                $notification->status_code .
                $notification->gross_amount .
                $serverKey
            );

            if ($signature !== $notification->signature_key) {
                \Log::warning('Midtrans callback: Invalid signature', [
                    'order_id' => $notification->order_id ?? 'null',
                    'expected' => $signature,
                    'received' => $notification->signature_key ?? 'null',
                    'request_body' => $request->all(),
                ]);
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            // Get transaction details from notification
            $midtransOrderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $paymentType = $notification->payment_type;
            $fraudStatus = $notification->fraud_status;

            \Log::info('Midtrans callback: Processing transaction', [
                'midtrans_order_id' => $midtransOrderId,
                'transaction_status' => $transactionStatus,
                'payment_type' => $paymentType,
            ]);

            // Find payment by midtrans_order_id (format: order_code-ATTEMPT-X-timestamp)
            $payment = Payment::where('midtrans_order_id', $midtransOrderId)->first();

            if (!$payment) {
                \Log::warning('Midtrans callback: Payment not found', [
                    'midtrans_order_id' => $midtransOrderId,
                    'available_payments' => Payment::pluck('midtrans_order_id')->toArray(),
                ]);
                return response()->json(['message' => 'Payment not found'], 404);
            }

            $order = $payment->order;

            if (!$order) {
                \Log::error('Midtrans callback: Order not found for payment', [
                    'payment_id' => $payment->id,
                    'midtrans_order_id' => $midtransOrderId,
                ]);
                return response()->json(['message' => 'Order not found'], 404);
            }

            // Create transaction record for history
            try {
                \App\Models\Transaction::create([
                    'order_id' => $order->id,
                    'payment_id' => $payment->id,
                    'midtrans_order_id' => $midtransOrderId,
                    'transaction_id' => $notification->transaction_id ?? null,
                    'amount' => $notification->gross_amount ?? $order->total,
                    'payment_type' => $paymentType ?? null,
                    'status' => $transactionStatus ?? null,
                    'raw_response' => json_encode($notification),
                ]);
            } catch (\Exception $e) {
                \Log::warning('Failed to create transaction record: ' . $e->getMessage());
            }

            // Update payment status
            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                $payment->update(['status' => 'lunas']);
                $order->update([
                    'payment_status' => 'sudah_dibayar',
                    'status' => 'dikemas',
                ]);
            } elseif ($transactionStatus == 'pending') {
                $payment->update(['status' => 'menunggu_pembayaran']);
                $order->update([
                    'payment_status' => 'menunggu_pembayaran',
                ]);
            } elseif ($transactionStatus === 'expire') {
                // ⏰ pembayaran kedaluwarsa
                $payment->update([
                    'status' => 'dibatalkan',
                ]);

                $order->update([
                    'payment_status' => 'dibatalkan',
                    'status' => 'dibatalkan',
                ]);
            }
            elseif (in_array($transactionStatus, ['deny', 'cancel'])) {
                $payment->update(['status' => 'gagal']);

                $order->update([
                    'payment_status' => 'dibatalkan',
                    'status' => 'dibatalkan',
                ]);
            }

            \Log::info('Midtrans callback: Success', [
                'midtrans_order_id' => $midtransOrderId,
                'transaction_status' => $transactionStatus,
                'payment_id' => $payment->id,
                'order_id' => $order->id,
            ]);

            return response()->json(['message' => 'Callback success']);
        } catch (\Exception $e) {
            \Log::error('Midtrans callback: Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            return response()->json(['message' => 'Callback error: ' . $e->getMessage()], 500);
        }
    }
}
