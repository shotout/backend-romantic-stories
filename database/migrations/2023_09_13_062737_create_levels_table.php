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
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('desc')->nullable();
            $table->tinyInteger('value')->nullable();
            $table->tinyInteger('status')->default(2);
            $table->timestamps();
        });

        DB::table('levels')->insert([
            ["name" => "level 1", "value" => 1, "created_at" => now()],
            ["name" => "level 2", "value" => 2, "created_at" => now()],
            ["name" => "level 3", "value" => 3, "created_at" => now()],
            ["name" => "level 4", "value" => 4, "created_at" => now()],
            ["name" => "level 5", "value" => 5, "created_at" => now()],
        ]);

        DB::table('medias')->insert([
            [
                "owner_id" => 1,
                "type" => "level",
                "name" => "1.png",
                "url" => "/assets/icons/levels/1.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 2,
                "type" => "level",
                "name" => "2.png",
                "url" => "/assets/icons/levels/2.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 3,
                "type" => "level",
                "name" => "3.png",
                "url" => "/assets/icons/levels/3.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 4,
                "type" => "level",
                "name" => "4.png",
                "url" => "/assets/icons/levels/4.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 5,
                "type" => "level",
                "name" => "5.png",
                "url" => "/assets/icons/levels/5.png",
                "created_at" => now()
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};
