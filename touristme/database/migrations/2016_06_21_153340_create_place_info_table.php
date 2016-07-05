<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaceInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('place_guide_info'))
        Schema::create('place_guide_info',function(Blueprint $table){
            $table->increments('id');
            $table->integer('guide_place_id');
            $table->text('info_id');
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
        if(Schema::hasTable('place_guide_info'))
        Schema::drop('place_guide_info');
           
       
    }
}
