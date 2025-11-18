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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->fulltext('idx_ft_name');
            $table->string('symbol',50)->index('idx_symbol');
            $table->string('iso',50);
            $table->boolean('publish')->default(false)->index('idx_publish');;
            $table->decimal('exhange_rate',4,2);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
