<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDa5ExportOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('da5_export_orders', function (Blueprint $table) {
            $table->id();
            $table->integer("staff_id")->unsigned()->nullable();
            $table->integer("total_quantity")->unsigned()->nullable();
            $table->integer("order_id")->unsigned()->nullable();
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
        Schema::dropIfExists('da5_export_orders');
    }
}
