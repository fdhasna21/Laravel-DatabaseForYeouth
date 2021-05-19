<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateShoppingbagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shoppingbags', function (Blueprint $table) {
            $table->string('shoppingbag_id')->primary();
            $table->string('shoppingbag_version_id')->nullable(false)->index();
            $table->integer('shoppingbag_quantity')->nullable(false);
            $table->timestamps();

            //Foreign Key : version_id, user_id
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
        Schema::dropIfExists('shoppingbags');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
