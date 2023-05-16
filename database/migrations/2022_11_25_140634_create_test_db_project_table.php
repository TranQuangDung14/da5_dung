<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestDbProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_db_project', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string("number_phone",20)->nullable();
            $table->string('email')->nullable();
            $table->string('adress')->nullable();
            $table->integer("testdb1_id")->unsigned()->nullable();
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
        Schema::dropIfExists('test_db_project');
    }
}
