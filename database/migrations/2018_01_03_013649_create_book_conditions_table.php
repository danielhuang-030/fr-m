<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookConditionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('book_conditions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('book_id')->unsigned()->index();
			$table->string('condition')->index();
			$table->integer('quantity');
			$table->decimal('price', 10);
			$table->boolean('in_stock')->default(0);
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
		Schema::drop('book_conditions');
	}

}
