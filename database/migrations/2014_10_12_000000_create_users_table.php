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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->integer('level_id')->default(1);
            $table->bigInteger('icon_id')->nullable();
            $table->bigInteger('category_id')->nullable();

            $table->bigInteger('avatar_male')->nullable();
            $table->bigInteger('avatar_female')->nullable();

            $table->string('language_id')->nullable();

            $table->string('name')->nullable();
            $table->string('gender')->nullable();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();

            $table->boolean('is_member')->default(false);
            $table->string('purchasely_id')->nullable();
            $table->string('device_id')->nullable();
            $table->string('fcm_token')->nullable();
            $table->boolean('notif_enable')->default(false);
            $table->boolean('notif_ads_enable')->default(false);
            $table->integer('notif_count')->default(0);
            $table->integer('notif_ads_count')->default(0);
            $table->tinyInteger('random_avatar')->default(0);

            $table->rememberToken();
            $table->tinyInteger('status')->default(2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
