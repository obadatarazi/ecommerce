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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->fulltext('idx_ft_name');
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->boolean('publish')->default(false)->index('idx_publish');
            $table->boolean('featured')->default(false)->index('idx_featured');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
