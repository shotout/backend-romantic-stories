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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->tinyInteger('status')->default(2);
            $table->timestamps();
        });

        DB::table('categories')->insert([
            ["name" => "Relationship", "created_at" => now()],
            ["name" => "I Miss You", "created_at" => now()],
            ["name" => "Dirty Mind", "created_at" => now()],
            ["name" => "Suprise Me", "created_at" => now()],
        ]);

        DB::table('medias')->insert([
            [
                "owner_id" => 1,
                "type" => "category",
                "model" => "anime",
                "name" => "relationship.png",
                "url" => "/assets/images/categories/anime/relationship.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 2,
                "type" => "category",
                "model" => "anime",
                "name" => "i_miss_u.png",
                "url" => "/assets/images/categories/anime/i_miss_u.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 3,
                "type" => "category",
                "model" => "anime",
                "name" => "dirty_mind.png",
                "url" => "/assets/images/categories/anime/dirty_mind.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 4,
                "type" => "category",
                "model" => "anime",
                "name" => "suprise_me.png",
                "url" => "/assets/images/categories/anime/suprise_me.png",
                "created_at" => now()
            ],

            [
                "owner_id" => 1,
                "type" => "category",
                "model" => "realistic",
                "name" => "relationship.png",
                "url" => "/assets/images/categories/realistic/relationship.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 2,
                "type" => "category",
                "model" => "realistic",
                "name" => "i_miss_u.png",
                "url" => "/assets/images/categories/realistic/i_miss_u.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 3,
                "type" => "category",
                "model" => "realistic",
                "name" => "dirty_mind.png",
                "url" => "/assets/images/categories/realistic/dirty_mind.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 4,
                "type" => "category",
                "model" => "realistic",
                "name" => "suprise_me.png",
                "url" => "/assets/images/categories/realistic/suprise_me.png",
                "created_at" => now()
            ],
        ]);

        DB::table('medias')->insert([
            [
                "owner_id" => 1,
                "type" => "category_cover",
                "model" => "anime",
                "name" => "relationship.png",
                "url" => "/assets/images/categories/anime/covers/relationship.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 2,
                "type" => "category_cover",
                "model" => "anime",
                "name" => "i_miss_u.png",
                "url" => "/assets/images/categories/anime/covers/i_miss_u.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 3,
                "type" => "category_cover",
                "model" => "anime",
                "name" => "dirty_mind.png",
                "url" => "/assets/images/categories/anime/covers/dirty_mind.png",
                "created_at" => now()
            ],

            [
                "owner_id" => 1,
                "type" => "category_cover",
                "model" => "realistic",
                "name" => "relationship.png",
                "url" => "/assets/images/categories/realistic/covers/relationship.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 2,
                "type" => "category_cover",
                "model" => "realistic",
                "name" => "i_miss_u.png",
                "url" => "/assets/images/categories/realistic/covers/i_miss_u.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 3,
                "type" => "category_cover",
                "model" => "realistic",
                "name" => "dirty_mind.png",
                "url" => "/assets/images/categories/realistic/covers/dirty_mind.png",
                "created_at" => now()
            ],
        ]);

        DB::table('medias')->insert([
            [
                "owner_id" => 1,
                "type" => "cover_audio",
                "model" => "anime",
                "name" => "relationship.png",
                "url" => "/assets/images/categories/anime/covers/audio/relationship.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 2,
                "type" => "cover_audio",
                "model" => "anime",
                "name" => "i_miss_u.png",
                "url" => "/assets/images/categories/anime/covers/audio/i_miss_u.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 3,
                "type" => "cover_audio",
                "model" => "anime",
                "name" => "dirty_mind.png",
                "url" => "/assets/images/categories/anime/covers/audio/dirty_mind.png",
                "created_at" => now()
            ],

            [
                "owner_id" => 1,
                "type" => "cover_audio",
                "model" => "realistic",
                "name" => "relationship.png",
                "url" => "/assets/images/categories/realistic/covers/audio/relationship.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 2,
                "type" => "cover_audio",
                "model" => "realistic",
                "name" => "i_miss_u.png",
                "url" => "/assets/images/categories/realistic/covers/audio/i_miss_u.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 3,
                "type" => "cover_audio",
                "model" => "realistic",
                "name" => "dirty_mind.png",
                "url" => "/assets/images/categories/realistic/covers/audio/dirty_mind.png",
                "created_at" => now()
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
