<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDa5InfoSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('da5_info_supplier', function (Blueprint $table) {
            $table->id();
            $table->string("name",100)->nullable();
            $table->string("email",100)->nullable();
            $table->string("adress",100)->nullable();
            $table->string("number_phone",20)->nullable();
            // $table->string("sectors",100);
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
        Schema::dropIfExists('da5_info_supplier');
    }
}
