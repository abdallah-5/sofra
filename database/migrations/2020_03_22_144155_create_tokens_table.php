<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTokensTable extends Migration {

	public function up()
	{
		Schema::create('tokens', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('token', 255);
			$table->enum('type', array('android', 'ios'));
			$table->integer('tokenable_id');
			$table->string('tokenable_type', 255);
		});
	}

	public function down()
	{
		Schema::drop('tokens');
	}
}