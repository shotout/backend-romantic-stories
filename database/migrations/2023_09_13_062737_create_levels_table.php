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
            $table->integer('value')->nullable();
            $table->string('value_desc')->nullable();
            $table->tinyInteger('status')->default(2);
            $table->timestamps();
        });

        Schema::create('user_level', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->integer('level_id')->default(1);
            $table->integer('point')->default(0);
            $table->tinyInteger('status')->default(2);
            $table->timestamps();
        });

        DB::table('levels')->insert([
            ["name" => "level 1", "desc" => "Romance Rookie", "value" => 0, "value_desc" => "0 XP", "created_at" => now()],
            ["name" => "level 2", "desc" => "Heartfelt Adventurer", "value" => 5, "value_desc" => "5 XP", "created_at" => now()],
            ["name" => "level 3", "desc" => "Passion Pioneer", "value" => 25, "value_desc" => "25 XP", "created_at" => now()],
            ["name" => "level 4", "desc" => "Flirty Fictionista", "value" => 80, "value_desc" => "80 XP", "created_at" => now()],
            ["name" => "level 5", "desc" => "Passion Prowler", "value" => 200, "value_desc" => "200 XP", "created_at" => now()],
            ["name" => "level 6", "desc" => "Heartfelt Voyager", "value" => 400, "value_desc" => "400 XP", "created_at" => now()],
            ["name" => "level 7", "desc" => "Sizzling Storyteller", "value" => 600, "value_desc" => "600 XP", "created_at" => now()],
            ["name" => "level 8", "desc" => "Naughty Novelist", "value" => 800, "value_desc" => "800 XP", "created_at" => now()],
            ["name" => "level 9", "desc" => "Erotales Superstar", "value" => 1200, "value_desc" => "1200 XP", "created_at" => now()],
            ["name" => "level 10", "desc" => "EroTales Legend", "value" => 1800, "value_desc" => "1800 XP", "created_at" => now()],
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
            [
                "owner_id" => 6,
                "type" => "level",
                "name" => "6.png",
                "url" => "/assets/icons/levels/6.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 7,
                "type" => "level",
                "name" => "7.png",
                "url" => "/assets/icons/levels/7.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 8,
                "type" => "level",
                "name" => "8.png",
                "url" => "/assets/icons/levels/8.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 9,
                "type" => "level",
                "name" => "9.png",
                "url" => "/assets/icons/levels/9.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 10,
                "type" => "level",
                "name" => "10.png",
                "url" => "/assets/icons/levels/10.png",
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
