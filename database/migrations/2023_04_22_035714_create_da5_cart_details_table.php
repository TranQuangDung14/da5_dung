<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDa5CartDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // chi tiết giỏ hàng
    public function up()
    {
        Schema::create('da5_cart_details', function (Blueprint $table) {
            $table->id();
            $table->integer("cart_id")->unsigned()->nullable();
            $table->integer("product_id")->unsigned()->nullable();
            $table->integer("quantity")->unsigned()->nullable();
            $table->decimal('price_by_quantity', 10, 2)->default(0);
            $table->string("discout",200)->nullable();

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
        Schema::dropIfExists('da5_cart_details');
    }
}
