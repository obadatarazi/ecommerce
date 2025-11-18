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
        $table->decimal('stock', 8,0)->default(value: 1);
        $table->dateTime('production_date')->default(now());
        $table->dateTime('expiration_date')->default(now());

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', callback: function (Blueprint $table) {
            $table->dropColumn('stock');
            $table->dropColumn('production_date');
            $table->dropColumn('expiration_date');

        });
    }
};
