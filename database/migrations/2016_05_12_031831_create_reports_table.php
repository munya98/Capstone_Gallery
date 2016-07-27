<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('reports', function(Blueprint $table){
            $table->increments('report_id');
            $table->string('reason');
            $table->timestamps();
            $table->integer('image_id')->unsigned();
            //$table->foreign('image_id')->references('image_id')->on('images');
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
        Schema::drop('reports');
    }
}
