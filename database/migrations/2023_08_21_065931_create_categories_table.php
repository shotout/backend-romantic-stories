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
                "name" => "relationship.png",
                "url" => "/assets/images/categories/relationship.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 2,
                "type" => "category",
                "name" => "i_miss_u.png",
                "url" => "/assets/images/categories/i_miss_u.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 3,
                "type" => "category",
                "name" => "dirty_mind.png",
                "url" => "/assets/images/categories/dirty_mind.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 4,
                "type" => "category",
                "name" => "suprise_me.png",
                "url" => "/assets/images/categories/suprise_me.png",
                "created_at" => now()
            ],
        ]);

        DB::table('medias')->insert([
            [
                "owner_id" => 1,
                "type" => "category_cover",
                "name" => "relationship.png",
                "url" => "/assets/images/categories/covers/relationship.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 2,
                "type" => "category_cover",
                "name" => "i_miss_u.png",
                "url" => "/assets/images/categories/covers/i_miss_u.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 3,
                "type" => "category_cover",
                "name" => "dirty_mind.png",
                "url" => "/assets/images/categories/covers/dirty_mind.png",
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
