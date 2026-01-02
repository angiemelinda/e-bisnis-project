<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Order;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_summary_and_orders_endpoints()
    {
        $user = User::factory()->create(['role' => 'dropshipper']);

        // Create two orders
        Order::create([
            'user_id' => $user->id,
            'order_code' => 'GH-RPT-001',
            'total' => 100000,
            'margin' => 10000,
            'status' => 'selesai',
            'payment_status' => 'sudah_dibayar',
        ]);

        Order::create([
            'user_id' => $user->id,
            'order_code' => 'GH-RPT-002',
            'total' => 200000,
            'margin' => 0,
            'status' => 'dikemas',
            'payment_status' => 'menunggu_pembayaran',
        ]);

        $resp1 = $this->actingAs($user)->get('/dropshipper/api/reports/summary');
        $resp1->assertStatus(200);
        $resp1->assertJsonPath('status', 'success');
        $resp1->assertJsonStructure(['status', 'data' => ['total_orders', 'total_revenue', 'total_estimated_margin', 'by_status']]);

        $resp2 = $this->actingAs($user)->get('/dropshipper/api/reports/orders');
        $resp2->assertStatus(200);
        $resp2->assertJsonPath('status', 'success');
        $resp2->assertJsonStructure(['status', 'data', 'meta']);
    }
}
