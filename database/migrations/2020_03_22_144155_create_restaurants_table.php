<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRestaurantsTable extends Migration {

	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 150);
			$table->string('email', 200);
			$table->string('password', 255);
			$table->string('phone', 150);
			$table->string('whatsapp', 255);
			$table->integer('region_id');
			$table->string('image', 255);
			$table->decimal('minimum_order');
			$table->decimal('delivery_charge');
			$table->timestamps();
			$table->enum('available', array('open', 'close'));
			$table->boolean('activate')->default(1);
			$table->string('contact_phone', 150);
			$table->string('api_token', 60)->unique()->nullable();
			$table->string('code', 6)->nullable();
		});
	}

	public function down()
	{
		Schema::drop('restaurants');
	}
}
