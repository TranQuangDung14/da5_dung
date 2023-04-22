<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDa5ImportOrdersDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('da5_import_orders_detail', function (Blueprint $table) {
            $table->id();
            $table->integer("import_order_id")->unsigned()->nullable();
            $table->integer("product_id")->unsigned()->nullable();
            $table->integer("quantity")->unsigned()->nullable();
            $table->integer("price")->unsigned()->nullable();
            // $table->string("discout",200)->nullable();
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
        Schema::dropIfExists('da5_import_orders_detail');
    }
}
