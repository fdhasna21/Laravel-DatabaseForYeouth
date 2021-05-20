<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateShoppingbagVersionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //TODO : isi tabel (cari tau gunanya pivot table dan nanti ngisi datanya gimana)
        Schema::create('shoppingbag_version', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            //Foreign Key : shoppingbag_id, version_id
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
        Schema::dropIfExists('shoppingbag_version');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
