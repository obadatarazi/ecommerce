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
        Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name')->fulltext('idx_ft_name');
        $table->text('description')->nullable();
        $table->boolean('publish')->default(false)->index('idx_publish');
        $table->timestamps();
        $table->softDeletes(); 
      });

        Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->bigInteger('category_id')->unsigned();
        $table->text('imge')->nullable();
        $table->string('name')->fulltext('idx_ft_name');
        $table->text('description')->nullable();
        $table->boolean('publish')->default(false)->index('idx_publish');
        $table->enum('type', ['GRANOLA', 'GRANOLA_BARS', 'PENNUT_BUTTER'])->default('GRANOLA')->index('idx_type');
        $table->decimal('price');
        $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
        $table->timestamps(); // created_at
        $table->softDeletes(); // deleted_at
      });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
};
