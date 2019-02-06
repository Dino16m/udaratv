<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Series extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series', function(Blueprint $table){
          $table->increments('id');
          $table->string('name');
          $table->string('series_path');
          $table->timestamps();
          $table->string('type');
          $table->string('run_time');
          $table->integer('views')->default('0');
          $table->integer('number_of_seasons');
          $table->text('short_description')->nullable();
          $table->string('image_link')->nullable();
          $table->string('imdb_link')->nullable();
          $table->string('first_letter_of_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('series');
    }
}
