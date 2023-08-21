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
                "name" => "1.png",
                "url" => "/assets/images/avatars/1.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 2,
                "type" => "avatar",
                "name" => "2.png",
                "url" => "/assets/images/avatars/2.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 3,
                "type" => "avatar",
                "name" => "3.png",
                "url" => "/assets/images/avatars/3.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 4,
                "type" => "avatar",
                "name" => "4.png",
                "url" => "/assets/images/avatars/4.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 5,
                "type" => "avatar",
                "name" => "5.png",
                "url" => "/assets/images/avatars/5.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 6,
                "type" => "avatar",
                "name" => "6.png",
                "url" => "/assets/images/avatars/6.png",
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
