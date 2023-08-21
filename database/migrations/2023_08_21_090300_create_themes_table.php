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
            $table->string('name')->nullable();
            $table->string('text_color')->nullable();
            $table->string('bg_color')->nullable();
            $table->tinyInteger('status')->default(2);
            $table->timestamps();
        });

        DB::table('themes')->insert([
            ["name" => "theme1", "text_color" => "#000000", "bg_color" => "#5873FF", "created_at" => now()],
            ["name" => "theme2", "text_color" => "#000000", "bg_color" => "#2C8272", "created_at" => now()],
            ["name" => "theme3", "text_color" => "#000000", "bg_color" => "#942AA7", "created_at" => now()],
            ["name" => "theme4", "text_color" => "#000000", "bg_color" => "#0D648B", "created_at" => now()],
            ["name" => "theme5", "text_color" => "#000000", "bg_color" => "#604A9E", "created_at" => now()],
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
