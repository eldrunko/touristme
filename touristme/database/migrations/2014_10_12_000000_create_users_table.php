<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('users'))
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('surname');
            $table->string('bio');
            $table->string('pic');
            $table->date('birth_date');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->string('api_token',60)->unique();//middleware="auth:api"
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
      // Schema::drop('users');
        return;
        return;
    }
}
