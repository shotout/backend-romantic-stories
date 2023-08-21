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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->tinyInteger('status')->default(2);
            $table->timestamps();
        });

        DB::table('languages')->insert([
            ["code" => "EN", "name" => "English", "created_at" => now()],
            ["code" => "ID", "name" => "Indonesia", "created_at" => now()],
        ]);

        DB::table('medias')->insert([
            [
                "owner_id" => 1,
                "type" => "lang",
                "name" => "en.png",
                "url" => "/assets/images/langs/en.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 2,
                "type" => "lang",
                "name" => "id.png",
                "url" => "/assets/images/langs/id.png",
                "created_at" => now()
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
