<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Naija extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('naija', function(Blueprint $table){
          $table->increments('id');
          $table->string('name');
          $table->string('file_path');
          $table->timestamps();
          $table->string('short_description')->nullable();
          $table->string('image_link')->nullable();
          $table->string('imdb_link')->nullable();
          $table->string('fist_letter_of_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('naija');
    }
}
