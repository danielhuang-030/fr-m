<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('book_categories', function(Blueprint $table)
		{
			$table->integer('book_id')->unsigned()->index();
			$table->integer('category_id')->unsigned()->index();
			$table->dateTime('created_at')->nullable();
			$table->primary(['book_id','category_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('book_categories');
	}

}
