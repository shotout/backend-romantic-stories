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
        Schema::create('user_tracking', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('time_usage')->default(0);
            $table->boolean('read_3_story')->default(false);
            $table->boolean('read_7_story')->default(false);
            $table->boolean('read_10_story')->default(false);
            $table->boolean('listen_3_story')->default(false);
            $table->boolean('listen_7_story')->default(false);
            $table->boolean('listen_10_story')->default(false);
            $table->dateTime('last_get_story')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_tracking');
    }
};
