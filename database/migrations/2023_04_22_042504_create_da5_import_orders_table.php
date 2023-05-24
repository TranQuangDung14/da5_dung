<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDa5ImportOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('da5_import_orders', function (Blueprint $table) {
            $table->id();
            $table->integer("staff_id")->unsigned()->nullable();
            $table->integer("supplier_id")->unsigned()->nullable();
            $table->integer("total_quantity")->unsigned()->nullable();
            $table->integer("total_cost")->unsigned()->nullable();
            // $table->string("discout",200)->nullable();
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
        Schema::dropIfExists('da5_import_orders');
    }
}
