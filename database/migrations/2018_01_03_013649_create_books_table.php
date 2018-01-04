<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBooksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('books', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('bwb_id')->unsigned()->index();
			$table->string('isbn10')->index();
			$table->string('isbn13')->index();
			$table->string('title');
			$table->string('slug')->unique();
			$table->text('description')->nullable();
			$table->string('format')->index();
			$table->decimal('weight', 10);
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
		Schema::drop('books');
	}

}
