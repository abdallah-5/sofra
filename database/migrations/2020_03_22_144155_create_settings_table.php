<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->text('about_us');
			$table->string('fb_link', 255);
			$table->string('inst_link', 255);
			$table->string('tw_link', 255);
			$table->decimal('commission');
			$table->string('bank_account', 255);
			$table->text('cometion_text');
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}
}