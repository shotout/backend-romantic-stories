<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icons', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->tinyInteger('status')->default(2);
            $table->timestamps();
        });

        DB::table('icons')->insert([
            ["name" => "icon 1", "created_at" => now()],
            ["name" => "icon 2", "created_at" => now()],
            ["name" => "icon 3", "created_at" => now()],
            ["name" => "icon 4", "created_at" => now()],
            ["name" => "icon 5", "created_at" => now()],
            ["name" => "icon 6", "created_at" => now()],
            ["name" => "icon 7", "created_at" => now()],
            ["name" => "icon 8", "created_at" => now()],
        ]);

        DB::table('medias')->insert([
            [
                "owner_id" => 1,
                "type" => "icon",
                "name" => "1.png",
                "url" => "/assets/icons/apps/1.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 2,
                "type" => "icon",
                "name" => "2.png",
                "url" => "/assets/icons/apps/2.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 3,
                "type" => "icon",
                "name" => "3.png",
                "url" => "/assets/icons/apps/3.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 4,
                "type" => "icon",
                "name" => "4.png",
                "url" => "/assets/icons/apps/4.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 5,
                "type" => "icon",
                "name" => "5.png",
                "url" => "/assets/icons/apps/5.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 6,
                "type" => "icon",
                "name" => "6.png",
                "url" => "/assets/icons/apps/6.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 7,
                "type" => "icon",
                "name" => "7.png",
                "url" => "/assets/icons/apps/7.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 8,
                "type" => "icon",
                "name" => "8.png",
                "url" => "/assets/icons/apps/8.png",
                "created_at" => now()
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('icons');
    }
};
