<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDa5BannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //banner
    public function up()
    {
        Schema::create('da5_banner', function (Blueprint $table) {
            $table->id();
            $table->string("image",200)->nullable();
            $table->integer("ordinal")->unsigned()->nullable();
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
        Schema::dropIfExists('da5_banner');
    }
}
