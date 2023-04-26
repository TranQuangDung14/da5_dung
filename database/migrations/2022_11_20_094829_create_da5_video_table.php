<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDa5VideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('da5_video', function (Blueprint $table) {
            $table->id();
            $table->integer("type_video_id")->unsigned()->nullable();
            $table->integer("staff_id")->unsigned()->nullable();
            $table->string("title",100)->nullable();
            $table->string("video",200)->nullable();
            $table->string("link_id",200)->nullable();
            $table->string("hashtag",100)->nullable();
            $table->string("description",100)->nullable();
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
        Schema::dropIfExists('da5_video');
    }
}
