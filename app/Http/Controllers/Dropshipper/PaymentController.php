<?php

namespace App\Http\Controllers\Dropshipper;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false; // sandbox
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    // 1️⃣ Daftar pembayaran (BELUM LUNAS)
    public function index()
    {
        $orders = Order::with('payment')
            ->where('user_id', auth()->id())
            ->whereHas('payment', function ($q) {
                $q->where('status', 'menunggu_pembayaran');
            })
            ->latest()
            ->get();

        return view('dropshipper.payments.index', compact('orders'));
    }

    // 2️⃣ Halaman bayar (Snap)
    public function pay(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        if ($order->snap_token) {
            return response($order->snap_token);
        }

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_code,
                'gross_amount' => (int) $order->total,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        $order->update(['snap_token' => $snapToken]);

        return response($snapToken);
    }

    // 3️⃣ Callback Midtrans (update database)
    public function callback(Request $request)
    {
        $payment = Payment::where('order_code', $request->order_id)->first();

        if (!$payment) return response()->json(['message' => 'Payment not found'], 404);

        if ($request->transaction_status == 'settlement') {
            $payment->update(['status' => 'lunas']);
            $payment->order->update(['status' => 'diproses']);
        }

        return response()->json(['message' => 'OK']);
    }
}
