<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function(Blueprint $table){
            $table->increments('comment_id');
            $table->string('comment');
            $table->integer('image_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('image_id')->references('image_id')->on('images');
            //$table->foreign('user_id')->references('id')->on('users');
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
        Schema::drop('comments');
    }
}
