<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDa5CartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // giỏ hàng
    public function up()
    {
        Schema::create('da5_carts', function (Blueprint $table) {
            $table->id();
            $table->integer("customer_id")->unsigned()->nullable();
            $table->integer("total_money")->unsigned()->nullable();
            $table->integer('discounted_price')->nullable();
            $table->integer("voucher_id")->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('da5_carts');
    }
}
