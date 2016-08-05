<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('likes', function(Blueprint $table){
            $table->primary(['image_id', 'user_id']);
            $table->integer('image_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('image_id')->references('image_id')->on('images')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('likes');
    }
}
