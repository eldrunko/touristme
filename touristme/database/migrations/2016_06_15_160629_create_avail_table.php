<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('availabilities'))
            return;
        /*Schema::create('availabilities',function(Blueprint $table){
            $table->increments('id');
            $table->integer('guide_id');
            $table->foreign('guide_id')->references('normal_user_id')->on('guides');
            $table->integer('place_id');
            $table->foreign('place_id')->references('id')->on('places');
            $table->date('begin');
            $table->date('end');
            $table->integer('day');
            $table->integer('time');
            $table->timestamps();
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('availabilities'))
        Schema::drop('availabilities');
    }
}
