<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payment_profiles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('card_type');
			$table->string('card_number')->index();
			$table->string('expiration_month');
			$table->string('expiration_year');
			$table->integer('user_id')->index();
			$table->integer('gateway_id')->index();
			$table->string('external_id')->index();
			$table->string('funding_type')->index();
			$table->string('vault_token')->index();
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
		Schema::drop('payment_profiles');
	}

}
