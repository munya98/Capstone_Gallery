<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create Albums Table
        Schema::create('albums', function(Blueprint $table){
            $table->increments('album_id');
            $table->string('name');
            $table->string('description');
            $table->string('path');
            $table->string('permission');
            $table->string('thumbnail')->default('default.jpg');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        //
        Schema::drop('albums');
    }
}
