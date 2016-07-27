<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create Images table
        Schema::create('images',function(Blueprint $table){
            $table->increments('image_id');
            $table->string('name');
            $table->string('path');
            $table->string('permission');
            $table->string('category');
            $table->string('mime');
            $table->string('display_filename');
            $table->integer('height');
            $table->integer('width');
            $table->integer('size');
            $table->integer('rating');
            $table->string('thumbnail');
            $table->integer('views');
            $table->timestamps();
            $table->integer('album_id')->unsigned();
            $table->integer('user_id')->unsigned();
            //$table->foreign('album_id')->references('album_id')->on('albums');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('images');
    }
}
