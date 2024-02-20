<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->string('name')->nullable();
            $table->tinyInteger('status')->default(2);
            $table->timestamps();
        });

        Schema::create('collection_stories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('collection_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('story_id')->nullable();
            $table->dateTime('expire')->nullable();
            $table->boolean('is_read_later')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collections','collection_stories');
    }
};
