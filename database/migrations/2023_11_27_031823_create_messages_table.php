<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->default(1);
            $table->integer('sequence')->nullable();
            $table->string('name')->nullable();
            $table->integer('time')->nullable();
            $table->string('sendout_time')->nullable();
            $table->string('offer')->nullable();
            $table->text('push_text')->nullable();
            $table->text('paywall')->nullable();
            $table->tinyInteger('status')->default(2);
            $table->timestamps();
        });

        Schema::create('user_messages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('message_id')->nullable();
            $table->dateTime('time')->nullable();
            $table->boolean('has_notif')->default(false);
            $table->timestamps();
        });

        DB::table('messages')->insert([
            [
                "sequence" => 1,
                "name" => "Push 1",
                "time" => 10,
                "sendout_time" => "10 mins after seeing the paywall for the first time",
                "offer" => "-50% (USD10)",
                "push_text" => "⏰Limited time offer!⏰ Elevate your experience with our UNLIMITED subscription at an exclusive 50% discount. Dive into sizzling tales of passion every day! 🌶️🔥",
                "paywall" => "Standard - PUSH after Onboarding (NO TRIAL / UNSKIPPABLE) - Weekly vs. 10 instead 20",
                "created_at" => now()
            ],
            [
                "sequence" => 2,
                "name" => "Push 2",
                "time" => 250,
                "sendout_time" => "4 h after push 1",
                "offer" => "-50% (USD10)",
                "push_text" => "Unlimited Stories, Themes and more - with no advertising! Get EroTales UNLIMITED now with 50% discount! 🔥😏",
                "paywall" => "Standard - PUSH after Onboarding (NO TRIAL / UNSKIPPABLE) - Weekly vs. 10 instead 20",
                "created_at" => now()
            ],
            [
                "sequence" => 3,
                "name" => "Push 3",
                "time" => 1450,
                "sendout_time" => "24h after push 1",
                "offer" => "-75% (USD5)",
                "push_text" => "Ready for endless intimacy?😏 Get 75% off on our UNLIMITED subscription and immerse yourself in a sea of exciting stories without limits! Subscribe now for unlimited passion! 🌶️",
                "paywall" => "Standard - PUSH after Onboarding (NO TRIAL / UNSKIPPABLE) - Weekly vs. 5 instead 20",
                "created_at" => now()
            ],
            [
                "sequence" => 4,
                "name" => "Push 4",
                "time" => 1690,
                "sendout_time" => "24h after push 2",
                "offer" => "-75% (USD5)",
                "push_text" => "⏰Hurry up! Get your 75% discount offer for EroTales UNLIMITED now - just for you! 😏",
                "paywall" => "Standard - PUSH after Onboarding (NO TRIAL / UNSKIPPABLE) - Weekly vs. 5 instead 20",
                "created_at" => now()
            ],
            [
                "sequence" => 5,
                "name" => "Push 5",
                "time" => 2890,
                "sendout_time" => "24h after push 3",
                "offer" => "-75% (USD5)",
                "push_text" => "⏰Experience excitement at an unbeatable price! Subscribe to our UNLIMITED package with a 75% discount and unlock intimate stories - every day, without limits. Join now!",
                "paywall" => "Standard - PUSH after Onboarding (NO TRIAL / UNSKIPPABLE) - Weekly vs. 5 instead 20",
                "created_at" => now()
            ],
            [
                "sequence" => 6,
                "name" => "Push 6",
                "time" => 3130,
                "sendout_time" => "24h after push 4",
                "offer" => "-75% (USD5)",
                "push_text" => "🙄Still not sure about EroTales UNLIMITED? Get 75% discount only now and spice up your life! 🌶️🔥",
                "paywall" => "Standard - PUSH after Onboarding (NO TRIAL / UNSKIPPABLE) - Weekly vs. 5 instead 20",
                "created_at" => now()
            ],
            [
                "sequence" => 7,
                "name" => "Push 7",
                "time" => 4330,
                "sendout_time" => "24h after push 5",
                "offer" => "-75% (USD5)",
                "push_text" => "Join our UNLIMITED community at 75% OFF! Enjoy UNLIMITED Stories and explore the depth of passion with a 75% discount. Subscribe today for endless tales! 😏⏰",
                "paywall" => "Standard - PUSH after Onboarding (NO TRIAL / UNSKIPPABLE) - Weekly vs. 5 instead 20",
                "created_at" => now()
            ],
            [
                "sequence" => 8,
                "name" => "Push 8",
                "time" => 4570,
                "sendout_time" => "24h after push 6",
                "offer" => "-75% (USD5)",
                "push_text" => "😍Get 75% discount on EroTales UNLIMITED now - be quick! 💥",
                "paywall" => "Standard - PUSH after Onboarding (NO TRIAL / UNSKIPPABLE) - Weekly vs. 5 instead 20",
                "created_at" => now()
            ],
            [
                "sequence" => 9,
                "name" => "Push 9",
                "time" => 5770,
                "sendout_time" => "24h after push 7",
                "offer" => "-75% (USD5)",
                "push_text" => "Unlock a world of captivating romance at 75% OFF!🔓 Get unlimited access to exciting Stories now with a 75% discount on our UNLIMITED subscription! Don't miss out! ⏰",
                "paywall" => "Standard - PUSH after Onboarding (NO TRIAL / UNSKIPPABLE) - Weekly vs. 5 instead 20",
                "created_at" => now()
            ],
            [
                "sequence" => 10,
                "name" => "Push 10",
                "time" => 6010,
                "sendout_time" => "24h after push 8",
                "offer" => "-75% (USD5)",
                "push_text" => "😍 Enjoying EroTales? Upgrade to the Full Ad-Free version with unlimited Stories, Themes and more - now with 75% off!🔥",
                "paywall" => "Standard - PUSH after Onboarding (NO TRIAL / UNSKIPPABLE) - Weekly vs. 5 instead 20",
                "created_at" => now()
            ],
            [
                "sequence" => 11,
                "name" => "Push 11",
                "time" => 7210,
                "sendout_time" => "24h after push 9",
                "offer" => "-75% (USD5)",
                "push_text" => "Unleash passion at an unbelievable price! Enjoy 75% off on our UNLIMITED subscription for unrestricted access to daily romantic stories. Don't miss this limited-time offer! ⏰🔓",
                "paywall" => "Standard - PUSH after Onboarding (NO TRIAL / UNSKIPPABLE) - Weekly vs. 5 instead 20",
                "created_at" => now()
            ],
            [
                "sequence" => 12,
                "name" => "Push 12",
                "time" => 7450,
                "sendout_time" => "24h after push 10",
                "offer" => "-75% (USD5)",
                "push_text" => "Unlimited Stories, Themes and more - with no advertising! Get EroTales UNLIMITED now with 75% discount! 😎",
                "paywall" => "Standard - PUSH after Onboarding (NO TRIAL / UNSKIPPABLE) - Weekly vs. 5 instead 20",
                "created_at" => now()
            ],
            [
                "sequence" => 13,
                "name" => "Push 13",
                "time" => 8650,
                "sendout_time" => "24h after push 11",
                "offer" => "-75% (USD5)",
                "push_text" => "⏰Experience romance's depth at an exclusive 75% discount! Subscribe now to our UNLIMITED package and delve into an endless collection of intimate tales. Limited time, unlimited stories! 😏🌶️",
                "paywall" => "Standard - PUSH after Onboarding (NO TRIAL / UNSKIPPABLE) - Weekly vs. 5 instead 20",
                "created_at" => now()
            ],
            [
                "sequence" => 14,
                "name" => "Push 14",
                "time" => 8890,
                "sendout_time" => "24h after push 12",
                "offer" => "-75% (USD5)",
                "push_text" => "Last chance for Unlimited Stories, Themes and more - with no advertising! Get EroTales UNLIMITED now with 75% discount and spice up your life! 🌶️😎",
                "paywall" => "Standard - PUSH after Onboarding (NO TRIAL / UNSKIPPABLE) - Weekly vs. 5 instead 20",
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
        Schema::dropIfExists('messages','user_messages');
    }
}
