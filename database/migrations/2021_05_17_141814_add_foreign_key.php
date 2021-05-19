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
        Schema::table('main_products', function (Blueprint $table) {
            //version_id, image_id, category_id, group_id
            $table->foreign('product_version_id', 'fk_product_version_id')->references('version_id')->on('version_products')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('product_merchandise_id', 'fk_product_merchandise_id')->references('merchandise_id')->on('category_merchandises') ->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('product_group_id', 'fk_product_group_id')->references('group_id')->on('category_groups')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });

        Schema::table('version_products', function (Blueprint $table) {
            //product_id, image_id
            $table->foreign('version_product_id', 'fk_version_product_id')->references('product_id')->on('main_products')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });

        Schema::table('shoppingbags', function(Blueprint $table){
            //version_id, user_id
            $table->foreign('shoppingbag_version_id', 'fk_shoppingbag_version_id')->references('version_id')->on('version_products')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreignId('user_id')->constrained();
        });

        Schema::table('order_statuses', function(Blueprint $table){
            //user_id
            $table->foreign('order_shoppingbag_id', 'fk_order_shoppingbag_id')->references('shoppingbag_id')->on('shoppingbags')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreignId('user_id')->constrained();
        });

        Schema::table('shoppingbag_version', function(Blueprint $table){
            //shoppingbag_id, version_id
            $table->foreign('shoppingbag_id', 'fk_sv_shoppingbag_id')->references('shoppingbag_id')->on('shoppingbags')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('version_id', 'fk_sv_version_id')->references('version_id')->on('version_products')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fk_product_version_id');
        Schema::dropIfExists('fk_product_merchandise_id');
        Schema::dropIfExists('fk_product_group_id');
        Schema::dropIfExists('fk_version_product_id');
        Schema::dropIfExists('fk_shoppingbag_product_id');
        Schema::dropIfExists('fk_shoppingbag_version_id');
        Schema::dropIfExists('fk_order_shoppingbag_id');
        Schema::dropIfExists('fk_sv_shoppingbag_id');
        Schema::dropIfExists('fk_sv_version_id');
    }
}
