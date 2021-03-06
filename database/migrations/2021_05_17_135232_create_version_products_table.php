<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateVersionProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('version_products', function (Blueprint $table) {
            $table->string('version_id')->primary();
            $table->string('version_product_id')->index()->nullable(false);
            $table->string('version_image_id')->index();
            $table->string('version_name')->nullable(false);
            $table->text('version_detail');
            $table->integer('version_price')->nullable(false);
            $table->integer('version_stock')->default(0)->nullable(false);
            $table->integer('version_sold')->default(0)->nullable(false);
            $table->timestamps();

            //Foreign Key : product_id, image_id
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
        Schema::dropIfExists('version_products');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
