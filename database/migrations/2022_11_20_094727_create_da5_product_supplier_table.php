<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDa5ProductSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('da5_product_supplier', function (Blueprint $table) {
            $table->id();
            $table->integer("info_supplier_id")->unsigned()->nullable();
            $table->string("name",100);
            $table->integer("amount")->unsigned();
            $table->string("weight",100);
            $table->integer("price")->unsigned()->nullable();
            $table->string("description",100)->nullable();
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
        Schema::dropIfExists('da5_product_supplier');
    }
}
