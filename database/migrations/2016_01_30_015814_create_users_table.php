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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('password', 255);
            $table->rememberToken();
            $table->integer('usergroup')->length(2);
            $table->integer('country')->length(4);
            $table->integer('pp_raw')->length(10);
            $table->integer('total_score');
            $table->integer('playcount');
            $table->float('accuracy');
            $table->integer('bantime')->length(11);
            $table->text('avatar');
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
        Schema::drop('users');
    }
}
