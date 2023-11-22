<?php

use App\Models\Plan;
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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->nullable();
            $table->tinyInteger('sequence')->nullable();
            $table->string('title')->nullable();
            $table->string('sub_title')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('stripe_name')->nullable();
            $table->string('stripe_id')->nullable();
            $table->float('price')->default(0);
            $table->string('abbreviation')->nullable();
            $table->boolean('is_show')->default(0);
            $table->boolean('is_special')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        DB::table('plans')->insert([
            [
                'type' => 1,
                'sequence' => 1,
                'title' => 'Free Plan',
                'sub_title' => '',
                'name' => 'free-trial',
                'slug' => 'free-trial',
                'stripe_name' => 'Free Plan',
                'stripe_id' => '',
                'price' => 0,
                'abbreviation' => '',
                'is_show' => 1,
                'is_special' => 0,
            ],
            [
                'type' => 2,
                'sequence' => 2,
                'title' => 'EroTales UNLIMITED',
                'sub_title' => '',
                'name' => '1 year subscription',
                'slug' => '1-year-subscription',
                'stripe_name' => '1 Year Subscription',
                'stripe_id' => 'price_1LxpXiKITpzX4txv1EYTif9n',
                'price' => 19.99,
                'abbreviation' => 'year',
                'is_show' => 1,
                'is_special' => 0,
            ],
            [
                'type' => 3,
                'sequence' => 3,
                'title' => 'EroTales UNLIMITED + Audio',
                'sub_title' => '',
                'name' => '1 year subscription',
                'slug' => '1-year-subscription',
                'stripe_name' => '1 Year Subscription',
                'stripe_id' => 'price_1M4JltKITpzX4txvmoWEcyvm',
                'price' => 39.99,
                'abbreviation' => 'year',
                'is_show' => 1,
                'is_special' => 0,
            ],
        ]);

        $free = array(
            (object) array(
                'check' => true,
                'title' => 'Unlimited Stories every day',
                'description' => 'Read as many Stories as you like - No waiting or interruptions',
            ),
            (object) array(
                'check' => false,
                'title' => "Access to Hundreds of Stories in our Library",
                'description' => "Choose freely from all Stories and all Genres in our Library",
            ),
            (object) array(
                'check' => false,
                'title' => "All Features unlocked",
                'description' => "Includes Full Access to all new Stories",
            ),
            (object) array(
                'check' => false,
                'title' => "Unlimited Custom Themes, Fonts and more",
                'description' => "Change anytime - without Ads",
            ),
            (object) array(
                'check' => false,
                'title' => "Adjust your character and your partner character anytime",
                'description' => "",
            ),
            (object) array(
                'check' => false,
                'title' => "No ads, no watermarks, no limitations",
                'description' => "Enjoy EroTales without Ads and Watermarks",
            ),
            (object) array(
                'check' => false,
                'title' => "LISTEN TO STORIES AS AUDIO-BOOKS ",
                'description' => "Enjoy all Stories as Audio-Books - Hands-free!",
            ),
        );

        $year = array(
            (object) array(
                'check' => true,
                'title' => 'Unlimited Stories every day',
                'description' => 'Read as many Stories as you like - No waiting or interruptions',
            ),
            (object) array(
                'check' => true,
                'title' => "Access to Hundreds of Stories in our Library",
                'description' => "Choose freely from all Stories and all Genres in our Library",
            ),
            (object) array(
                'check' => true,
                'title' => "All Features unlocked",
                'description' => "Includes Full Access to all new Stories",
            ),
            (object) array(
                'check' => true,
                'title' => "Unlimited Custom Themes, Fonts and more",
                'description' => "Change anytime - without Ads",
            ),
            (object) array(
                'check' => true,
                'title' => "Adjust your character and your partner character anytime",
                'description' => "",
            ),
            (object) array(
                'check' => true,
                'title' => "No ads, no watermarks, no limitations",
                'description' => "Enjoy EroTales without Ads and Watermarks",
            ),
            (object) array(
                'check' => false,
                'title' => "LISTEN TO STORIES AS AUDIO-BOOKS ",
                'description' => "Enjoy all Stories as Audio-Books - Hands-free!",
            ),
        );

        $year_audio = array(
            (object) array(
                'check' => true,
                'title' => 'Unlimited Stories every day',
                'description' => 'Read as many Stories as you like - No waiting or interruptions',
            ),
            (object) array(
                'check' => true,
                'title' => "Access to Hundreds of Stories in our Library",
                'description' => "Choose freely from all Stories and all Genres in our Library",
            ),
            (object) array(
                'check' => true,
                'title' => "All Features unlocked",
                'description' => "Includes Full Access to all new Stories",
            ),
            (object) array(
                'check' => true,
                'title' => "Unlimited Custom Themes, Fonts and more",
                'description' => "Change anytime - without Ads",
            ),
            (object) array(
                'check' => true,
                'title' => "Adjust your character and your partner character anytime",
                'description' => "",
            ),
            (object) array(
                'check' => true,
                'title' => "No ads, no watermarks, no limitations",
                'description' => "Enjoy EroTales without Ads and Watermarks",
            ),
            (object) array(
                'check' => true,
                'title' => "LISTEN TO STORIES AS AUDIO-BOOKS ",
                'description' => "Enjoy all Stories as Audio-Books - Hands-free!",
            ),
        );

        // free plan
        $p1 = Plan::where('id', 1)->first();
        $p1->notes = $free;
        $p1->update();

        // 1 year plan
        $p2 = Plan::where('id', 2)->first();
        $p2->notes = $year;
        $p2->update();

        // 1 year plan + audio
        $p3 = Plan::where('id', 3)->first();
        $p3->notes = $year_audio;
        $p3->update();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
};
