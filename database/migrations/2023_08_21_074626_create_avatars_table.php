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
        Schema::create('avatars', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('gender')->nullable();
            $table->tinyInteger('status')->default(2);
            $table->timestamps();
        });

        DB::table('avatars')->insert([
            ["name" => "avatar1", "gender" => "male", "created_at" => now()],
            ["name" => "avatar2", "gender" => "male", "created_at" => now()],
            ["name" => "avatar3", "gender" => "male", "created_at" => now()],
            ["name" => "avatar4", "gender" => "female", "created_at" => now()],
            ["name" => "avatar5", "gender" => "female", "created_at" => now()],
            ["name" => "avatar6", "gender" => "female", "created_at" => now()],
        ]);

        DB::table('medias')->insert([
            [
                "owner_id" => 1,
                "type" => "avatar",
                "model" => "anime",
                "name" => "1.png",
                "url" => "/assets/images/avatars/anime/1.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 2,
                "type" => "avatar",
                "model" => "anime",
                "name" => "2.png",
                "url" => "/assets/images/avatars/anime/2.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 3,
                "type" => "avatar",
                "model" => "anime",
                "name" => "3.png",
                "url" => "/assets/images/avatars/anime/3.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 4,
                "type" => "avatar",
                "model" => "anime",
                "name" => "4.png",
                "url" => "/assets/images/avatars/anime/4.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 5,
                "type" => "avatar",
                "model" => "anime",
                "name" => "5.png",
                "url" => "/assets/images/avatars/anime/5.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 6,
                "type" => "avatar",
                "model" => "anime",
                "name" => "6.png",
                "url" => "/assets/images/avatars/anime/6.png",
                "created_at" => now()
            ],

            [
                "owner_id" => 1,
                "type" => "avatar",
                "model" => "realistic",
                "name" => "1.png",
                "url" => "/assets/images/avatars/realistic/1.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 2,
                "type" => "avatar",
                "model" => "realistic",
                "name" => "2.png",
                "url" => "/assets/images/avatars/realistic/2.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 3,
                "type" => "avatar",
                "model" => "realistic",
                "name" => "3.png",
                "url" => "/assets/images/avatars/realistic/3.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 4,
                "type" => "avatar",
                "model" => "realistic",
                "name" => "4.png",
                "url" => "/assets/images/avatars/realistic/4.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 5,
                "type" => "avatar",
                "model" => "realistic",
                "name" => "5.png",
                "url" => "/assets/images/avatars/realistic/5.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 6,
                "type" => "avatar",
                "model" => "realistic",
                "name" => "6.png",
                "url" => "/assets/images/avatars/realistic/6.png",
                "created_at" => now()
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avatars');
    }
};
