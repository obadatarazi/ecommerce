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
        Schema::create('multi_type_settings', function (Blueprint $table) {
            $table->id();
            $table->string('setting_key', 100)->unique('idx_unique_setting_key');
            $table->fullText('setting_key', 'idx_ft_setting_key');
            $table->longText('value');
            $table->enum('type', ["EMAIL", "LINK", "NUMBER", "PHONE_NUMBER", "TEXT"])->index('idx_type');
            $table->longText('description')->nullable();
            $table->timestamps();
        });

        Schema::create('visual_settings', function (Blueprint $table) {
            $table->id();
            $table->string('setting_key', 100)->unique('idx_unique_visual_setting_key');
            $table->fullText('setting_key', 'idx_ft_visual_setting_key');
            $table->text('image_file_url')->nullable();
            $table->text('link')->nullable();
            $table->timestamps();
        });

        Schema::create('visual_setting_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('visual_setting_id')->unsigned();
            $table->string('locale')->index();
            $table->string('title');
            $table->longText('description')->nullable();

            $table->unique(['visual_setting_id', 'locale']);
            $table->foreign('visual_setting_id')->references('id')->on('visual_settings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multi_type_settings');
        Schema::dropIfExists('visual_settings');
        Schema::dropIfExists('visual_setting_translations');
    }
};
