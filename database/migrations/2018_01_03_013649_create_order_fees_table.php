<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderFeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_fees', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('order_id')->index();
			$table->string('type')->index();
			$table->string('name');
			$table->decimal('total', 10);
			$table->integer('sort');
			$table->text('meta')->nullable();
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
		Schema::drop('order_fees');
	}

}
