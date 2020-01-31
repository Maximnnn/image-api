<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ImageParameters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imageParameters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('imageId');
            $table->integer('width');
            $table->integer('height');
            $table->string('color', 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imageParameters');
    }
}
