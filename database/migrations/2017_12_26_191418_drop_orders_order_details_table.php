<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropOrdersOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_details', function (Blueprint $table) {
            DB::statement('ALTER TABLE order_details DROP FOREIGN KEY `order_details_order_id_foreign`');
            DB::statement('DROP INDEX order_details_order_id_foreign ON order_details');
        });
        Schema::dropIfExists('order_details');

        Schema::table('orders', function (Blueprint $table) {
            DB::statement('ALTER TABLE orders DROP FOREIGN KEY `orders_user_id_foreign`');
            DB::statement('DROP INDEX orders_user_id_foreign ON orders');
        });
        Schema::dropIfExists('orders');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('uuid');
            $table->decimal('total', 15, 2);
            $table->tinyInteger('status')->default(0)->comment('状态0：新订单1：已发货2：已收货3：无效订单');


//            $table->integer('address_id')->unsigned();
//            $table->foreign('address_id')->references('id')->on('addresses');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });

        Schema::create('order_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('numbers');

//            $table->integer('product_id')->unsigned();
//            $table->foreign('product_id')->references('id')->on('products');

            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');
        });

    }
}
