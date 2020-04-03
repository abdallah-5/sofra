<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsMethodTable extends Migration {

	public function up()
	{
		Schema::create('payments_method', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 150);
		});
	}

	public function down()
	{
		Schema::drop('payments_method');
	}
}