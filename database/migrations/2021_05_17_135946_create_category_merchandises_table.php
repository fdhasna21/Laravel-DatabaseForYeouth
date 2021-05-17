<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateCategoryMerchandisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_merchandises', function (Blueprint $table) {
            $table->string('merchandise_id')->primary();
            $table->string('merchandise_name')->nullable(false);
            $table->timestamps();
            //Foreign Key : image_ID
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
        Schema::dropIfExists('category_merchandises');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
