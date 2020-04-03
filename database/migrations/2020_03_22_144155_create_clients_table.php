<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 150);
			$table->string('email', 200);
			$table->string('password', 255);
			$table->string('phone', 150);
			$table->integer('region_id');
			$table->timestamps();
			$table->string('image', 255);
			$table->boolean('activate')->default(1);
			$table->string('api_token', 60)->unique()->nullable();
			$table->string('code', 6)->nullable();
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}
