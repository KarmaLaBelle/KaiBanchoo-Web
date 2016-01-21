<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metrics', function ($table) {
            $table->increments('id');
            $table->string('user',64);
            $table->boolean('GlContextAvailable');
            $table->string('GlVendor',64);
            $table->string('GlVersion',64);
            $table->string('GlRenderer',64);
            $table->string('GlShader',64);
            $table->boolean('CanUseFBO');
            $table->boolean('CanUseVBO');
            $table->boolean('DotNet35');
            $table->boolean('DotNet40');
            $table->boolean('DotNet45');
            $table->string('SurfaceType',64);
            $table->string('OS',64);
            $table->string('OsuVersion',64);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('metrics');
    }
}
