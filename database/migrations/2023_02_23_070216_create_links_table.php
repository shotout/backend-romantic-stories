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
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->default(1);
            $table->string('flag')->nullable();
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->tinyInteger('status')->default(2);
            $table->timestamps();
        });

        DB::table('links')->insert([
            ['flag' => 'social', 'title' => 'Facebook','url' => 'https://www.facebook.com/erotalesApp?mibextid=LQQJ4d', 'created_at' => now()],
            ['flag' => 'social', 'title' => 'Twitter','url' => 'https://twitter.com/erotales', 'created_at' => now()],
            ['flag' => 'social', 'title' => 'Instagram','url' => 'https://www.instagram.com/erotales_app', 'created_at' => now()],
            ['flag' => 'landing', 'title' => 'Imprint','url' => 'https://erotalesapp.com/imprint', 'created_at' => now()],
            ['flag' => 'landing', 'title' => 'Terms & Conditions','url' => 'https://erotalesapp.com/terms', 'created_at' => now()],
            ['flag' => 'landing', 'title' => 'Privacy policy','url' => 'https://erotalesapp.com/privacy', 'created_at' => now()],
        ]);

        DB::table('medias')->insert([
            [
                "owner_id" => 1,
                "type" => "link",
                "name" => "facebook.png",
                "url" => "/assets/icons/links/facebook.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 2,
                "type" => "link",
                "name" => "twitter.png",
                "url" => "/assets/icons/links/twitter.png",
                "created_at" => now()
            ],
            [
                "owner_id" => 3,
                "type" => "link",
                "name" => "instagram.png",
                "url" => "/assets/icons/links/instagram.png",
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
        Schema::dropIfExists('links');
    }
};
