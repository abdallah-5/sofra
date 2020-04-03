<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 150);
			$table->text('description');
			$table->decimal('price');
			$table->decimal('offer_price');
			$table->integer('time_for_prepearing');
			$table->integer('restaurant_id');
		});
	}

	public function down()
	{
		Schema::drop('products');
	}
}