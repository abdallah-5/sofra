<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('client_id');
			$table->integer('restaurant_id');
			$table->enum('status', array('pending', 'accepted', 'deliverd', 'rejected', 'declined'));
			$table->integer('payment_method_id');
			$table->decimal('cost');
			$table->decimal('delivery_cost');
			$table->decimal('total');
			$table->decimal('commission');
			$table->text('notes');
			$table->string('address', 255);
			$table->string('special_order', 255);
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}