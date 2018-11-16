<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NaijaQuality extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('naijaQuality', function(Blueprint $table){
          $table->increments('id');
          $table->integer('naija_id');
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
        Schema::dropIfExists('naijaQuality');
    }
}
