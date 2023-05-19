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
            $table->string("code",100)->nullable();
            $table->integer("category_id")->unsigned()->nullable();
            $table->integer("brand_id")->unsigned()->nullable();
            $table->string("name",100)->nullable();
            $table->integer("default_price")->nullable()->unsigned();
            $table->string("description",10000)->nullable();
            $table->string("tech_specs",5000)->nullable();
            $table->string("hashtag",100)->nullable();
            $table->integer("quantity")->nullable()->unsigned();
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
