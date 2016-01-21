<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeatmapListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beatmapsRanks', function ($table) {
            $table->increments('id');
            $table->string('beatmapID',34);
            $table->string('user',24);
            $table->integer('score')->length(9);
            $table->integer('combo')->length(9);
            $table->integer('count50')->length(9);
            $table->integer('count100')->length(9);
            $table->integer('count300')->length(9);
            $table->integer('countMiss')->length(9);
            $table->integer('countKatu')->length(9);
            $table->integer('countGeki')->length(9);
            $table->boolean('fc');
            $table->string('mods',10);
            $table->integer('avatarID')->length(11);
            $table->integer('timestamp')->length(12);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('beatmapsRanks');
    }
}
