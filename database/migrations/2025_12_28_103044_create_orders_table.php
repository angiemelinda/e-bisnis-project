<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('order_code')->unique();

            $table->decimal('total', 15, 2);
            $table->decimal('margin', 15, 2)->default(0);

            // STATUS PESANAN
            $table->enum('status', [
                'menunggu_pembayaran',
                'dikemas',
                'dikirim',
                'selesai'
            ])->default('menunggu_pembayaran');

            // STATUS PEMBAYARAN
            $table->enum('payment_status', [
                'menunggu_pembayaran',
                'sudah_dibayar'
            ])->default('menunggu_pembayaran');

            $table->string('courier')->nullable();
            $table->string('resi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
