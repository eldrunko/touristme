<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('infos')){
            Schema::create('infos',function(Blueprint $table){
            $table->increments('id');
            $table->integer('guide_place_id');//meglio nn fake
            $table->integer('cost');
            $table->integer('time');
            $table->date('date');
            $table->boolean('reserved');
            $table->unique(array('date','time','guide_place_id'));
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('infos')){
            Schema::drop('infos');
        }
    }
}
