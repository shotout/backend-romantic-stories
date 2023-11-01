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
                'sequence' => null,
                'title' => '',
                'sub_title' => '',
                'name' => 'free-trial',
                'slug' => 'free-trial',
                'stripe_name' => 'Free Plan',
                'stripe_id' => '',
                'price' => 0,
                'abbreviation' => '',
                'is_show' => 0,
                'is_special' => 0,
            ],

            [
                'type' => 2,
                'sequence' => 3,
                'title' => 'MONTHLY USD 4/month',
                'sub_title' => '',
                'name' => '1-month subscription',
                'slug' => '1-month-subscription',
                'stripe_name' => 'Monthly Plan',
                'stripe_id' => 'price_1LxpU5KITpzX4txvtEkn6kUY',
                'price' => 4,
                'abbreviation' => 'month',
                'is_show' => 1,
                'is_special' => 0,
            ],
            [
                'type' => 3,
                'sequence' => 2,
                'title' => 'ANNUAL USD 19.99/year (only USD 1.67/month)',
                'sub_title' => '3 DAYS FREE TRIAL',
                'name' => '1-year-subscription',
                'slug' => '1-year-subscription',
                'stripe_name' => '1 Year Subscription',
                'stripe_id' => 'price_1M4JltKITpzX4txvmoWEcyvm',
                'price' => 19.99,
                'abbreviation' => 'year',
                'is_show' => 1,
                'is_special' => 1,
            ],
            [
                'type' => 4,
                'sequence' => 1,
                'title' => 'LIFETIME USD 150 one time',
                'sub_title' => '',
                'name' => 'lifetime subscription',
                'slug' => 'lifetime-subscription',
                'stripe_name' => 'Lifetime Plan',
                'stripe_id' => 'price_1LxpXiKITpzX4txv1EYTif9n',
                'price' => 150,
                'abbreviation' => 'life time',
                'is_show' => 1,
                'is_special' => 0,
            ],

            [
                'type' => 5,
                'sequence' => null,
                'title' => '',
                'sub_title' => '',
                'name' => '1-month free subscription',
                'slug' => '1-month-free-subscription',
                'stripe_name' => '1 Month Free Plan',
                'stripe_id' => '',
                'price' => 0,
                'abbreviation' => '',
                'is_show' => 0,
                'is_special' => 0,
            ],
        ]);

        $free = array(
            (object) array(
                'check' => true,
                'title' => 'Free 1 story per day',
                'description' => "Use all aspects of the app with Full Access without limits and without ads!",
            ),
            (object) array(
                'check' => false,
                'title' => "No ads, no limits, no watermarks",
                'description' => "Use all aspects of the app with Full Access without limits and without ads!",
            ),
            (object) array(
                'check' => false,
                'title' => "Thousands of Stories that you can't find anywhere else",
                'description' => "Plus all future themes and new quotes included in the package!",
            ),
        );

        $year = array(
            (object) array(
                'check' => true,
                'title' => 'No ads, no limits, no watermarks',
                'description' => 'Use all aspects of the app with Full Access without limits and without ads!',
            ),
            (object) array(
                'check' => true,
                'title' => "Unlimited access to thousands of Stories that you can't find anywhere else",
                'description' => "Don't limit yourself to 1 story per day. Read as much as you want from thousands of stories in the library.",
            ),
            (object) array(
                'check' => true,
                'title' => "Choose and change category as many as you want",
                'description' => "Change",
            ),
        );

        // free plan
        $p1 = Plan::where('id', 1)->first();
        $p1->notes = $free;
        $p1->update();

        // 1 year plan
        $p1 = Plan::where('id', 3)->first();
        $p1->notes = $year;
        $p1->update();
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
