<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('parent_transaction_id')->after('order_id')->nullable()->index();
            $table->renameColumn('transaction_id', 'gateway_transaction_id');
            $table->renameColumn('refund_target_transaction_id', 'gateway_refund_target_transaction_id');
            $table->dropColumn('card_number');
            $table->integer('payment_profile_id')->after('parent_transaction_id')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('parent_transaction_id');
            $table->renameColumn('gateway_transaction_id', 'transaction_id');
            $table->renameColumn('gateway_refund_target_transaction_id', 'refund_target_transaction_id');
            $table->string('card_number')->after('type')->nullable();
            $table->dropColumn('payment_profile_id');
        });
    }
}
