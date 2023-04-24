<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDa5OrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('da5_order', function (Blueprint $table) {
            $table->id();
            $table->integer("customer_id")->unsigned()->nullable();
            $table->integer("payment_method")->unsigned()->nullable();
            $table->integer("export_order_id")->unsigned()->nullable();
            $table->string("delivery_date",200)->nullable();
            $table->integer("shipping_fee")->unsigned()->nullable();
            $table->string("receiver_name",200)->nullable();
            $table->string("receiver_address",200)->nullable();
            $table->integer("status")->default(1);
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
        Schema::dropIfExists('da5_order');
    }
}
