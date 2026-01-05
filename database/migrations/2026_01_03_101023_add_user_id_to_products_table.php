<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Check if column doesn't exist before adding
            if (!Schema::hasColumn('products', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('category_id')->constrained('users')->onDelete('cascade');
            }
        });
        
        // Alternative: Use raw SQL if Schema methods don't work
        // DB::statement('ALTER TABLE products ADD COLUMN IF NOT EXISTS user_id BIGINT UNSIGNED NULL AFTER category_id');
        // DB::statement('ALTER TABLE products ADD CONSTRAINT IF NOT EXISTS products_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};
