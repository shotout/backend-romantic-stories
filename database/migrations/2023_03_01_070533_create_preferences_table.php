<?php

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
        Schema::create('preferences', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable();
            $table->string('field')->nullable();
            $table->text('value')->nullable();
            $table->tinyInteger('status')->default(2);
            $table->timestamps();
        });

        DB::table('preferences')->insert([
            [
                'category' => 'preference',
                'field' => 'theme_preference',
                'value' => '{"theme_mode":"menu-light","header_background":"header-purple","menu_background":"navbar-purple","menu_brand_background":"brand-blue","menu_item_color":"active-red","navbar_image":"navbar-image-5","menu-icon-colored":"icon-colored","menu_list_icon":"menu-item-icon-style5","menu_dropdown_icon":"drp-icon-style2"}',
                "created_at" => now() 
            ],
            [
                'category' => 'app_setting',
                'field' => 'force_show_paywall',
                'value' => 'true',
                "created_at" => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preferences');
    }
};
