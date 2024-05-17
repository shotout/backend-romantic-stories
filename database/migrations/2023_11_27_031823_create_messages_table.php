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
                "offer" => "FULL PRICE",
                "push_text" => "⏰Limited time offer!⏰ Elevate your experience with our UNLIMITED Subscription. Dive into an unlimited amount of sizzling tales of passion whenever you like! 🌶️🔥",
                "paywall" => "inAPP Paywall Annual vs Monthly",
                "created_at" => now()
            ],
            [
                "sequence" => 2,
                "name" => "Push 2",
                "time" => 250,
                "sendout_time" => "4h after push 1",
                "offer" => "FULL PRICE",
                "push_text" => "Unlimited Stories, Themes and more - with no advertising! Get EroTales UNLIMITED now! 🔥😏",
                "paywall" => "inAPP Paywall Annual vs Monthly",
                "created_at" => now()
            ],
            [
                "sequence" => 3,
                "name" => "Push 3",
                "time" => 1450,
                "sendout_time" => "24h after push 1",
                "offer" => "FULL PRICE",
                "push_text" => "Ready for endless intimacy?😏 Get our UNLIMITED Subscription now and immerse yourself in a sea of exciting stories without limits! Subscribe now for unlimited passion! 🌶️",
                "paywall" => "inAPP Paywall Annual vs Monthly",
                "created_at" => now()
            ],
            [
                "sequence" => 4,
                "name" => "Push 4",
                "time" => 1690,
                "sendout_time" => "24h after push 2",
                "offer" => "FULL PRICE",
                "push_text" => "⏰Hurry up! Get your EroTales UNLIMITED Subscription now - just for you! 😏",
                "paywall" => "inAPP Paywall Annual vs Monthly",
                "created_at" => now()
            ],
            [
                "sequence" => 5,
                "name" => "Push 5",
                "time" => 2890,
                "sendout_time" => "48h after push 1",
                "offer" => "FULL PRICE",
                "push_text" => "⏰Experience excitement! Subscribe to our UNLIMITED package and unlock intimate stories - every day, without limits. Join now!",
                "paywall" => "inAPP Paywall Annual vs Monthly",
                "created_at" => now()
            ],
            [
                "sequence" => 6,
                "name" => "Push 6",
                "time" => 3130,
                "sendout_time" => "48h after push 2",
                "offer" => "-50%",
                "push_text" => "🙄Still not sure about EroTales UNLIMITED? Get 50% discount only now and spice up your life! 🌶️🔥",
                "paywall" => "Annual vs Monthly - Offer 50% disc",
                "created_at" => now()
            ],
            [
                "sequence" => 7,
                "name" => "Push 7",
                "time" => 4330,
                "sendout_time" => "72h after push 1",
                "offer" => "-50%",
                "push_text" => "Join our UNLIMITED community at 50% OFF! Enjoy UNLIMITED Stories and explore the depth of passion with a 50% discount. Subscribe today for endless tales! 😏⏰",
                "paywall" => "Annual vs Monthly - Offer 50% disc",
                "created_at" => now()
            ],
            [
                "sequence" => 8,
                "name" => "Push 8",
                "time" => 4570,
                "sendout_time" => "72h after push 2",
                "offer" => "-50%",
                "push_text" => "😍Get 50% discount on EroTales UNLIMITED now - be quick! 💥",
                "paywall" => "Annual vs Monthly - Offer 50% disc",
                "created_at" => now()
            ],
            [
                "sequence" => 9,
                "name" => "Push 9",
                "time" => 5770,
                "sendout_time" => "96h after push 1",
                "offer" => "-50%",
                "push_text" => "Unlock a world of captivating romance at 50% OFF!🔓 Get unlimited access to exciting Stories now with a 50% discount on our UNLIMITED subscription! Don't miss out! ⏰",
                "paywall" => "Annual vs Monthly - Offer 50% disc",
                "created_at" => now()
            ],
            [
                "sequence" => 10,
                "name" => "Push 10",
                "time" => 6010,
                "sendout_time" => "96h after push 2",
                "offer" => "-50%",
                "push_text" => "😍 Enjoying EroTales? Upgrade to the Full Ad-Free version with unlimited Stories, Themes and more - now with 50% off!🔥",
                "paywall" => "Annual vs Monthly - Offer 50% disc",
                "created_at" => now()
            ],
            [
                "sequence" => 11,
                "name" => "Push 11",
                "time" => 7210,
                "sendout_time" => "120h after push 1",
                "offer" => "-50%",
                "push_text" => "Unleash passion at an unbelievable price! Enjoy 50% off on our UNLIMITED subscription for unrestricted access to daily romantic stories. Don't miss this limited-time offer! ⏰🔓",
                "paywall" => "Annual vs Monthly - Offer 50% disc",
                "created_at" => now()
            ],
            [
                "sequence" => 12,
                "name" => "Push 12",
                "time" => 7450,
                "sendout_time" => "120h after push 2",
                "offer" => "-50%",
                "push_text" => "Unlimited Stories, Themes and more - with no advertising! Get EroTales UNLIMITED now with 50% discount! 😎",
                "paywall" => "Annual vs Monthly - Offer 50% disc",
                "created_at" => now()
            ],
            [
                "sequence" => 13,
                "name" => "Push 13",
                "time" => 8650,
                "sendout_time" => "144h after push 1",
                "offer" => "-50%",
                "push_text" => "⏰Experience romance's depth at an exclusive 50% discount! Subscribe now to our UNLIMITED package and delve into an endless collection of intimate tales. Limited time, unlimited stories! 😏🌶️",
                "paywall" => "Annual vs Monthly - Offer 50% disc",
                "created_at" => now()
            ],
            [
                "sequence" => 14,
                "name" => "Push 14",
                "time" => 8890,
                "sendout_time" => "144h after push 2",
                "offer" => "-50%",
                "push_text" => "Last chance for Unlimited Stories, Themes and more - with no advertising! Get EroTales UNLIMITED now with 50% discount and spice up your life! 🌶️😎",
                "paywall" => "Annual vs Monthly - Offer 50% disc",
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
