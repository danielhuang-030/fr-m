<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrders2ndTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->string('shipping_first_name')->nullable();
            $table->string('shipping_last_name')->nullable();
            $table->string('shipping_country')->nullable();
            $table->integer('shipping_state_id')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_addr1')->nullable();
            $table->string('shipping_addr2')->nullable();
            $table->string('shipping_zipcode')->nullable();
            $table->string('shipping_phone')->nullable();
            $table->string('billing_first_name')->nullable();
            $table->string('billing_last_name')->nullable();
            $table->string('billing_country')->nullable();
            $table->integer('billing_state_id')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_addr1')->nullable();
            $table->string('billing_addr2')->nullable();
            $table->string('billing_zipcode')->nullable();
            $table->text('memo')->nullable();
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('original_total', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->string('status')->index();
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
        Schema::dropIfExists('orders');
    }
}
