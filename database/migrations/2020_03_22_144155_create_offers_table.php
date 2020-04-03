<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOffersTable extends Migration {

	public function up()
	{
		Schema::create('offers', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('image', 255);
			$table->integer('restaurant_id');
			$table->string('title', 255);
			$table->text('details');
			$table->date('from');
			$table->date('to');
		});
	}

	public function down()
	{
		Schema::drop('offers');
	}
}