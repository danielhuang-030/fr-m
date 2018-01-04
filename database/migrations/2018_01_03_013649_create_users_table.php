<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('email');
			$table->string('password');
			$table->string('avatar')->nullable();
			$table->integer('login_count')->default(0);
			$table->string('active_token');
			$table->boolean('is_active')->default(0);
			$table->string('remember_token')->nullable();
			$table->integer('gateway_id')->nullable()->index();
			$table->string('external_id')->nullable()->index();
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
		Schema::drop('users');
	}

}
