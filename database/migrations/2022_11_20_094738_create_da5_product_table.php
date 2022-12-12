<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDa5ProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('da5_product', function (Blueprint $table) {
            $table->id();
            $table->integer("category_id")->unsigned()->nullable();
            // $table->integer("amount")->unsigned();
            $table->string("name",100);
            $table->integer("default_price")->unsigned();
            $table->integer("price")->unsigned();
            $table->string("image",200)->nullable();
            $table->string("description",10000)->nullable();
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
        Schema::dropIfExists('da5_product');
    }
}
