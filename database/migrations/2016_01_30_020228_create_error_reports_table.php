<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErrorReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('error_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user');
            $table->integer('i');
            $table->integer('osumode');
            $table->integer('gamemode');
            $table->integer('gametime');
            $table->integer('audiotime');
            $table->string('culture');
            $table->string('b');
            $table->string('bc');
            $table->string('exception');
            $table->string('feedback');
            $table->string('stacktrace');
            $table->string('iltrace');
            $table->string('version');
            $table->string('exehash');
            $table->text('config');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('error_reports');
    }
}
