<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_details', function(Blueprint $table){
            //user_id, image_id
            $table->foreignId('user_id')->constrained();
        });

        Schema::table('main_products', function (Blueprint $table) {
            //category_merchandise_id, category_group_id, image_id
            $table->foreignId('category_merchandise_id')->constrained()->onUpdate('CASCADE');
            $table->foreignId('category_group_id')->constrained()->onUpdate('CASCADE');
        });

        Schema::table('version_products', function (Blueprint $table) {
            //main_product_id, image_id
            $table->foreignId('main_product_id')->constrained()->onUpdate('CASCADE');
        });

        Schema::table('shoppingbags', function(Blueprint $table){
            //version_product_id, user_id
            $table->foreignId('version_product_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('order_statuses_id')->nullable()->constrained()->onUpdate('CASCADE');
        });

        Schema::table('order_statuses', function(Blueprint $table){
            //user_id
            $table->foreignId('user_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
