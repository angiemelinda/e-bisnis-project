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

        return view('dropshipper.payments', compact('orders'));
    }

    // 2️⃣ Halaman bayar (Snap)
    public function pay(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        $payment = Payment::firstOrCreate(
            ['order_id' => $order->id],
            [
                'midtrans_order_id' => $order->order_code,
                'status' => 'menunggu_pembayaran',
            ]
        );

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


}
