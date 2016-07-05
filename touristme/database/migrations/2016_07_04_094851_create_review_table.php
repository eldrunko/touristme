<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('reviews'))
        Schema::create('reviews',function(Blueprint $table){
            $table->increments('id');
            $table->integer('reservation_id')->unique();
            $table->text('text');
            $table->integer('rating');
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
        if(Schema::hasTable('reviews')){
            Schema::drop('reviews');
        }
    }
}
