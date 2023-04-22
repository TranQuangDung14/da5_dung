<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDa5StoreInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // thông tin cửa hàng
    public function up()
    {
        Schema::create('da5_store_information', function (Blueprint $table) {
            $table->id();
            $table->string("map",1000)->nullable();
            $table->string("number_phone",50)->nullable();
            $table->string("email",50)->nullable();
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
        Schema::dropIfExists('da5_store_information');
    }
}
