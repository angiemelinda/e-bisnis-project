<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // pastikan kolom cukup panjang
            $table->string('status', 50)->change();
            $table->string('payment_status', 50)->change();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->string('status', 50)->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status', 30)->change();
            $table->string('payment_status', 30)->change();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->string('status', 30)->change();
        });
    }
};
