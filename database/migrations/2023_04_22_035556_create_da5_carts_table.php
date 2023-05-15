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
            $table->decimal("total_money", 10, 2)->unsigned()->default(0);
            $table->decimal('discounted_price', 10, 2)->default(0);
            $table->integer("voucher_id")->unsigned()->nullable();
            $table->decimal('real_money', 10, 2)->default(0);
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
