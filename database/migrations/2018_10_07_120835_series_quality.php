<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeriesQuality extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series_quality', function(Blueprint $table){
          $table->increments('id');
          $table->integer('series_id');
          $table->integer('episodes_id');
          $table->timestamps();
          $table->string('quality');
          $table->string('file_path');
          $table->integer('season_number');
          $table->integer('season_id');
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
        Schema::dropIfExists('series_quality');
    }
}
