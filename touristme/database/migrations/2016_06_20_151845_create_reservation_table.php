<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('reservations'))
        Schema::create('reservations',function(Blueprint $table){
            $table->increments('id');
            $table->text('user_id');
            $table->integer('info_id')->unique();
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
        if(Schema::hasTable('reservations')){
            Schema::drop('reservations');
        }
    }
}
