<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_fees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->index();
            $table->string('type')->index();
            $table->string('name');
            $table->decimal('total', 10, 2);
            $table->integer('sort');
            $table->json('meta')->nullable();
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
        Schema::dropIfExists('order_fees');
    }
}
