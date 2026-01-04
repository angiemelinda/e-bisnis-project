<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;

class ShippingTest extends TestCase
{
    use RefreshDatabase;

    public function test_track_returns_local_data_when_no_provider()
    {
        $user = User::factory()->create(['role' => 'dropshipper']);

        $order = Order::create([
            'user_id' => $user->id,
            'order_code' => 'GH-TEST-001',
            'total' => 150000,
            'margin' => 0,
            'status' => 'dikirim',
            'payment_status' => 'sudah_dibayar',
            'courier' => 'jne',
            'resi' => 'TRK123456789',
        ]);

        // create product to satisfy FK
        $product = \App\Models\Product::create([
            'sku' => 'SKU-001',
            'name' => 'Test Product',
            'category_id' => null,
            'price' => 150000,
            'stock' => 10,
            'status' => 'active',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => 150000,
            'subtotal' => 150000,
        ]);

        $response = $this->actingAs($user)->get('/dropshipper/api/tracking/' . $order->resi);

        $response->assertStatus(200);
        $response->assertJsonPath('status', 'success');
        $response->assertJsonPath('data.resi', 'TRK123456789');
        $response->assertJsonPath('data.courier', 'jne');
    }
}
