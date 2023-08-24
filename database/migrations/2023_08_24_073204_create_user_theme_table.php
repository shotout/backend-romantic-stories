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
        Schema::create('user_theme', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('theme_id')->nullable();
            $table->string('name')->nullable();
            $table->string('text_color')->nullable();
            $table->string('font_size')->nullable();
            $table->string('font_family')->nullable();
            $table->string('bg_color')->nullable();
            $table->string('theme_color')->nullable();
            $table->tinyInteger('status')->default(2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_theme');
    }
};
