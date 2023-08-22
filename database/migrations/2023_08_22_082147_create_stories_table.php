<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sequence')->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->string('author')->nullable();
            $table->string('title')->nullable();
            $table->longText('content')->nullable();
            $table->boolean('has_notif')->default(false);
            $table->integer('count_share')->default(0);
            $table->tinyInteger('status')->default(2);
            $table->timestamps();
        });

        Schema::create('user_story', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('story_id')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->string('flag')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stories','user_story');
    }
};
