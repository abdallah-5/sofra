<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderProductTable extends Migration {

	public function up()
	{
		Schema::create('order_product', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('order_id');
			$table->integer('product_id');
			$table->decimal('price');
			$table->integer('quantity');
			$table->string('notes', 255);
		});
	}

	public function down()
	{
		Schema::drop('order_product');
	}
}