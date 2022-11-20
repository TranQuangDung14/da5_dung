<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDa5TransportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('da5_transport', function (Blueprint $table) {
            $table->id();
            $table->integer("staff_id")->unsigned()->nullable();
            $table->integer("status")->default(1);
            $table->integer("status_oder")->nullable();
            $table->dateTime("intend_time")->nullable();
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
        Schema::dropIfExists('da5_transport');
    }
}
