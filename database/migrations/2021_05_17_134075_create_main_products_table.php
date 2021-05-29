<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateMainProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name')->nullable(false);
            $table->string('product_category')->nullable(false);
            $table->text('product_detail')->default('')->nullable(false);
            $table->date('product_release')->default(now())->nullable(false);
            $table->integer('product_sold')->default(0)->nullable(false)->unsigned();
            $table->float('product_rate', 3, 2)->default(0.00)->nullable(false)->unsigned();
            $table->integer('product_wishlisted')->default(0)->nullable(false)->unsigned();
            $table->timestamps();

            //Foreign Key : version_id, image_id, category_id, group_id
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::dropIfExists('main_products');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
