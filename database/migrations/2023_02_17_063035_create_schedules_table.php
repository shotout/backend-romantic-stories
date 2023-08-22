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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->boolean('anytime')->default(false);
            $table->tinyInteger('often')->default(0);
            $table->tinyInteger('counter_notif')->default(0);
            $table->text('timer')->nullable();
            $table->text('timer_local')->nullable();
            $table->string('timezone')->nullable();
            $table->time('start')->nullable();
            $table->time('end')->nullable();
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
        Schema::dropIfExists('schedules');
    }
};
