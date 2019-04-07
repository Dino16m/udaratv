<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('episodes', function(Blueprint $table){
            $table->integer('compressed')->nullable();
        });
        Schema::table('movies', function(Blueprint $table){
            $table->integer('compressed');
        });
        Schema::table('seriesquality', function(Blueprint $table){
            $table->integer('compressed')->nullable();
            $table->string('raw_path')->nullable();
        });
        Schema::table('moviequality', function(Blueprint $table){
            $table->integer('compressed')->nullable();
            $table->string('raw_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('episodes', function(Blueprint $table){
            $table->dropColumn('compressed');
        });
        Schema::table('allmovies', function(Blueprint $table){
            $table->integer('compressed');
        });
        Schema::table('seriesquality', function(Blueprint $table){
            $table->dropColumn('compressed');
            $table->dropColumn('raw_path');
        });
        Schema::table('moviequality', function(Blueprint $table){
            $table->dropColumn('compressed');
            $table->dropColumn('raw_path');
        });
    }
}
