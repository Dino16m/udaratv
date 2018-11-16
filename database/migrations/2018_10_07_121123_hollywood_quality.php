<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HollywoodQuality extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hollywoodQuality', function(Blueprint $table){
          $table->increments('id');
          $table->integer('hollywood_id');
          $table->string('quality');
          $table->string('file_path');
          $table->integer('number_downloaded');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('hollywoodQuality');
    }
}
