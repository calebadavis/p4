<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotoUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
                Schema::create('photo_user', function($table) {

                        $table->integer('user_id')->unsigned();
                        $table->integer('photo_id')->unsigned();
                        
                        $table->foreign('user_id')->references('id')->on('users');
                        $table->foreign('photo_id')->references('id')->on('photos');
                        
                });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('photo_user');
	}

}
