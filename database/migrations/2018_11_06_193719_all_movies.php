<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AllMovies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('allmovies', function(Blueprint $table){
          $table->increments('id');
          $table->string('name');
          $table->string('file_path');
          $table->string('type');
          $table->integer('views')->default('0');
          $table->integer('run_time')->nullable();
          $table->string('short_description')->nullable();
          $table->string('image_link')->nullable();
          $table->string('imdb_link')->nullable();
          $table->string('first_letter_of_name');
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
       Schema::dropIfExists('allmovies');
    }
}
