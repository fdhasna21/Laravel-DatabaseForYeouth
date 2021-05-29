<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOrderInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('order_total')->default(0)->nullable(false)->unsigned();
            $table->text('order_receiver')->nullable(false);
            $table->enum('order_state', ['Processed', 'Shipping', 'Delivered'])->nullable(false);
            $table->timestamp('created_at')->nullable(true);
            //$table->timestamps();


            //Foreign Key : user_id, shopping_id
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
        Schema::dropIfExists('order_infos');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
