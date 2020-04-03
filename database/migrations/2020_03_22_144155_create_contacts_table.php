<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration {

	public function up()
	{
		Schema::create('contacts', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 150);
			$table->string('email', 255);
			$table->string('phone', 150);
			$table->text('message');
			$table->enum('type_of_message', array('complaint', 'suggestion', 'enquiry'));
		});
	}

	public function down()
	{
		Schema::drop('contacts');
	}
}