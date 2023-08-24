<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_free')->default(false);
            $table->string('name')->nullable();
            $table->string('text_color')->nullable();
            $table->string('font_size')->nullable();
            $table->string('font_family')->nullable();
            $table->string('bg_color')->nullable();
            $table->string('theme_color')->nullable();
            $table->tinyInteger('status')->default(2);
            $table->timestamps();
        });

        DB::table('themes')->insert([
            [
                "name" => "theme1",
                "text_color" => "#000000",
                "font_size" => "12",
                "font_family" => "arial",
                "bg_color" => "#FFFFFF",
                "theme_color" => "#5873FF",
                "created_at" => now()
            ],
            [
                "name" => "theme2",
                "text_color" => "#000000",
                "font_size" => "12",
                "font_family" => "arial",
                "bg_color" => "#FFFFFF",
                "theme_color" => "#2C8272",
                "created_at" => now()
            ],
            [
                "name" => "theme3",
                "text_color" => "#000000",
                "font_size" => "12",
                "font_family" => "arial",
                "bg_color" => "#FFFFFF",
                "theme_color" => "#942AA7",
                "created_at" => now()
            ],
            [
                "name" => "theme4",
                "text_color" => "#000000",
                "font_size" => "12",
                "font_family" => "arial",
                "bg_color" => "#FFFFFF",
                "theme_color" => "#0D648B",
                "created_at" => now()
            ],
            [
                "name" => "theme5",
                "text_color" => "#000000",
                "font_size" => "12",
                "font_family" => "arial",
                "bg_color" => "#FFFFFF",
                "theme_color" => "#604A9E",
                "created_at" => now()
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};
