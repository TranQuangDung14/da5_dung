<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDa5StaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('da5_staff', function (Blueprint $table) {
            $table->id();
            $table->string("name",100)->nullable();
            $table->integer("user_id")->nullable();
            $table->date("date_of_birth")->nullable();
            $table->string("sex",5)->nullable();
            $table->string("number_phone",20)->nullable();
            $table->string("email",100)->nullable();
            $table->string("adress",100)->nullable();
            $table->string("possion",100)->nullable();
            $table->string("department",100)->nullable();
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
        Schema::dropIfExists('da5_staff');
    }
}
