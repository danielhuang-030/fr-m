<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWebhookEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('webhook_events', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->index();
			$table->string('external_id')->index();
			$table->integer('gateway_id')->index();
			$table->string('type');
			$table->text('raw_data');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('webhook_events');
	}

}
