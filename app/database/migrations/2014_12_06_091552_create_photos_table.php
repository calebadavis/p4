<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
                Schema::create('photos', function($table) {

                    $table->increments('id');
		    $table->string('file');
		    $table->string('thumb');
                    $table->string('photographer');
		    $table->string('model');
                    $table->timestamps();
		    $table->integer('gallery_id')->unsigned();
                    $table->foreign('gallery_id')->references('id')->on('galleries');
                });

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('photos');
	}

}
