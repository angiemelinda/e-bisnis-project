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
        Schema::table('images', function (Blueprint $table) {
            if (!Schema::hasColumn('images', 'product_id')) {
                $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('cascade');
            }
            if (!Schema::hasColumn('images', 'path')) {
                $table->string('path')->nullable()->after('product_id');
            }
            if (!Schema::hasColumn('images', 'is_primary')) {
                $table->boolean('is_primary')->default(false)->after('path');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            if (Schema::hasColumn('images', 'is_primary')) {
                $table->dropColumn('is_primary');
            }
            if (Schema::hasColumn('images', 'path')) {
                $table->dropColumn('path');
            }
            if (Schema::hasColumn('images', 'product_id')) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            }
        });
    }
};
