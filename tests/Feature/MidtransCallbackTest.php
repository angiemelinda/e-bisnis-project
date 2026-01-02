<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;

class MidtransCallbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_callback_creates_transaction_and_updates_order()
    {
        $user = User::factory()->create();

        $order = Order::create([
            'user_id' => $user->id,
            'order_code' => 'GH-TRX-001',
            'total' => 50000,
            'margin' => 0,
            'status' => 'belum_dibayar',
            'payment_status' => 'menunggu_pembayaran',
        ]);


        // Create a Notification-like instance that will be injected
        $notification = new class extends \Midtrans\Notification {
            public function __construct() {}
        };

        $notification->order_id = $order->order_code;
        $notification->transaction_status = 'settlement';
        $notification->payment_type = 'bank_transfer';
        $notification->transaction_id = 'TRX-123';
        $notification->gross_amount = $order->total;

        // Bind the instance so the controller receives it via method injection
        $this->instance(\Midtrans\Notification::class, $notification);

        $resp = $this->post('/midtrans/callback');
        $resp->assertStatus(200);
        $resp->assertJson(['message' => 'Callback success']);

        // Order should be updated
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'payment_status' => 'sudah_dibayar',
            'status' => 'dikemas',
        ]);

        // Transaction should be recorded
        $this->assertDatabaseHas('transactions', [
            'order_id' => $order->id,
            'transaction_id' => 'TRX-123',
            'status' => 'settlement',
        ]);
    }
}
