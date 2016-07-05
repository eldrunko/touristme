<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrueTableRel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('guide_place'))
        Schema::create('guide_place',function(Blueprint $table){
            $table->increments('id');
            $table->integer('guide_id');
            $table->integer('place_id');
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
       // if(Schema::hasTable('guide_place'))
        //return;
        Schema::drop('guide_place');
    }
}
