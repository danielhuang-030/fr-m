<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->integer('order_id')->index()->nullable();
            $table->decimal('amount_in_cents', 8, 2)->nullable();
            $table->char('currency', 5)->nullable();
            $table->string('refund_reason')->nullable();
            $table->decimal('refunded_amount_in_cents', 8, 2)->nullable();
            $table->string('fail_reason')->nullable();
            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->string('card_number')->nullable();
            $table->string('gateway_id')->index()->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('refund_target_transaction_id')->nullable();
            $table->text('memo')->nullable();
            $table->timestamp('charged_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamp('traded_at')->nullable();
            $table->timestamps();

            $table->index(['type', 'status', 'traded_at']);
            $table->index(['gateway_id', 'transaction_id']);
            $table->index(['gateway_id', 'refund_target_transaction_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
