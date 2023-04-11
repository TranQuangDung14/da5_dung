<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDa5WarehouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('da5_warehouse', function (Blueprint $table) {
            $table->id();
            $table->integer("product_supplier_id")->unsigned()->nullable();
            $table->integer("product_id")->unsigned()->nullable();
            $table->integer("amount")->unsigned()->nullable();
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
        Schema::dropIfExists('da5_warehouse');
    }
}
