<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesananTable extends Migration
{
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();

            $table->string('kode_pesanan')->unique();

            $table->foreignId('supplier_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->integer('total_harga');

            $table->enum('status', [
                'baru',
                'diproses',
                'dikirim',
                'selesai',
                'dibatalkan'
            ])->default('baru');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
}
