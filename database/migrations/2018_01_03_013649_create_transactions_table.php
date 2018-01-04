<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transactions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->index();
			$table->integer('order_id')->nullable()->index();
			$table->integer('parent_transaction_id')->nullable()->index();
			$table->integer('payment_profile_id')->nullable()->index();
			$table->decimal('amount_in_cents')->nullable();
			$table->string('currency')->nullable();
			$table->string('refund_reason')->nullable();
			$table->decimal('refunded_amount_in_cents')->nullable();
			$table->string('fail_reason')->nullable();
			$table->string('status')->nullable();
			$table->string('type')->nullable();
			$table->string('gateway_id')->nullable()->index();
			$table->string('gateway_transaction_id')->nullable();
			$table->string('gateway_refund_target_transaction_id')->nullable();
			$table->text('memo')->nullable();
			$table->dateTime('charged_at')->nullable();
			$table->dateTime('refunded_at')->nullable();
			$table->dateTime('failed_at')->nullable();
			$table->dateTime('traded_at')->nullable();
			$table->timestamps();
			$table->index(['type','status','traded_at']);
			$table->index(['gateway_id','gateway_transaction_id'], 'transactions_gateway_id_transaction_id_index');
			$table->index(['gateway_id','gateway_refund_target_transaction_id'], 'transactions_gateway_id_refund_target_transaction_id_index');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('transactions');
	}

}
