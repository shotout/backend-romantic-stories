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

            $table->bigInteger('icon_id')->nullable();
            $table->bigInteger('category_id')->nullable();

            $table->bigInteger('avatar_male')->nullable();
            $table->bigInteger('avatar_female')->nullable();

            $table->string('theme_id')->nullable();
            $table->string('language_id')->nullable();

            $table->string('name')->nullable();
            $table->string('gender')->nullable();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
