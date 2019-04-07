<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Subscribers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscribers', function(Blueprint $table){
             $table->string('movie_name');
        });
        Schema::create('subscribers', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->timestamps();
            $table->string('movie_name');
            $table->integer('dispatched')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscribers');
    }
}
