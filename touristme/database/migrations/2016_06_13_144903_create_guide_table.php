<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuideTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('guides'))
        Schema::create('guides',function(Blueprint $table){
            $table->increments('id');
            $table->integer('normal_user_id')->unsigned();
            $table->foreign('normal_user_id')->references('id')->on('users');
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
        if(Schema::hasTable('guides'))
        Schema::drop('guides');

            return;
        return;
    }
}
