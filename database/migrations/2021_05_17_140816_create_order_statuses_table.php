<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOrderStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->string('order_id')->primary();
            $table->string('order_shoppingbag_id')->nullable(false)->index();
            $table->integer('order_total')->default(0)->nullable(false);
            $table->text('order_receiver')->nullable(false);
            $table->enum('order_state', ['Processed', 'Shipping', 'Delivered'])->nullable(false);
            $table->timestamps();

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
        Schema::dropIfExists('order_statuses');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
