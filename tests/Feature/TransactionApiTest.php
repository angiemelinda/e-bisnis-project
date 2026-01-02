<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Order;
use App\Models\Transaction;

class TransactionApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_api_returns_only_user_transactions()
    {
        $user = User::factory()->create(['role' => 'dropshipper']);
        $other = User::factory()->create(['role' => 'dropshipper']);

        $order1 = Order::create([
            'user_id' => $user->id,
            'order_code' => 'GH-TRX-10',
            'total' => 100000,
            'status' => 'selesai',
            'payment_status' => 'sudah_dibayar',
        ]);

        $order2 = Order::create([
            'user_id' => $other->id,
            'order_code' => 'GH-TRX-11',
            'total' => 200000,
            'status' => 'selesai',
            'payment_status' => 'sudah_dibayar',
        ]);

        Transaction::create([
            'order_id' => $order1->id,
            'midtrans_order_id' => $order1->order_code,
            'transaction_id' => 'TRX1',
            'amount' => 100000,
            'status' => 'settlement',
        ]);

        Transaction::create([
            'order_id' => $order2->id,
            'midtrans_order_id' => $order2->order_code,
            'transaction_id' => 'TRX2',
            'amount' => 200000,
            'status' => 'settlement',
        ]);

        $resp = $this->actingAs($user)->get('/dropshipper/api/transactions');
        $resp->assertStatus(200);
        $resp->assertJsonPath('status', 'success');
        $this->assertCount(1, $resp->json('data'));
    }

    public function test_show_api_returns_transaction_detail()
    {
        $user = User::factory()->create(['role' => 'dropshipper']);

        $order = Order::create([
            'user_id' => $user->id,
            'order_code' => 'GH-TRX-20',
            'total' => 50000,
            'status' => 'selesai',
            'payment_status' => 'sudah_dibayar',
        ]);

        $trx = Transaction::create([
            'order_id' => $order->id,
            'midtrans_order_id' => $order->order_code,
            'transaction_id' => 'TRX20',
            'amount' => 50000,
            'status' => 'settlement',
            'raw_response' => ['a' => 'b'],
        ]);

        $resp = $this->actingAs($user)->get('/dropshipper/api/transactions/' . $trx->id);
        $resp->assertStatus(200);
        $resp->assertJsonPath('status', 'success');
        $this->assertEquals('TRX20', $resp->json('data.transaction_id'));
    }

    public function test_index_api_filters()
    {
        $user = User::factory()->create(['role' => 'dropshipper']);

        // older transaction
        $order1 = Order::create([
            'user_id' => $user->id,
            'order_code' => 'GH-FILT-1',
            'total' => 10000,
            'status' => 'selesai',
            'payment_status' => 'sudah_dibayar',
            'created_at' => now()->subDays(10),
        ]);

        $t1 = Transaction::create([
            'order_id' => $order1->id,
            'midtrans_order_id' => $order1->order_code,
            'transaction_id' => 'TF1',
            'amount' => 10000,
            'status' => 'settlement',
            'payment_type' => 'bank_transfer',
            'created_at' => now()->subDays(10),
        ]);

        // recent transaction
        $order2 = Order::create([
            'user_id' => $user->id,
            'order_code' => 'GH-FILT-2',
            'total' => 50000,
            'status' => 'selesai',
            'payment_status' => 'sudah_dibayar',
            'created_at' => now(),
        ]);

        $t2 = Transaction::create([
            'order_id' => $order2->id,
            'midtrans_order_id' => $order2->order_code,
            'transaction_id' => 'TF2',
            'amount' => 50000,
            'status' => 'settlement',
            'payment_type' => 'credit_card',
            'created_at' => now(),
        ]);

        // filter by payment_type
        $resp = $this->actingAs($user)->get('/dropshipper/api/transactions?payment_type=credit_card');
        $resp->assertStatus(200);
        $data = $resp->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals('TF2', $data[0]['transaction_id']);

        // filter by date range to include only recent
        $from = now()->subDays(1)->toDateString();
        $resp2 = $this->actingAs($user)->get("/dropshipper/api/transactions?from={$from}");
        $resp2->assertStatus(200);
        $this->assertCount(1, $resp2->json('data'));

        // filter by amount_min
        $resp3 = $this->actingAs($user)->get('/dropshipper/api/transactions?amount_min=20000');
        $resp3->assertStatus(200);
        $this->assertCount(1, $resp3->json('data'));

        // filter by order_code
        $resp4 = $this->actingAs($user)->get('/dropshipper/api/transactions?order_code=GH-FILT-1');
        $resp4->assertStatus(200);
        $this->assertCount(1, $resp4->json('data'));
    }
}
