<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecentlyUpdated extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recently_updated', function(Blueprint $table){
          $table->increments('id');
          $table->string('video_name');
          $table->string('season')->nullable();
          $table->string('episode')->nullable();
          $table->integer('should_show')->nullable();
          $table->string('video_link');
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
        Schema::dropIfExists('recently_updated');
    }
}
