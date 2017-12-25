<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('card_type', 15);
            $table->string('card_number')->index();
            $table->string('expiration_month', 2);
            $table->string('expiration_year', 4);
            $table->integer('user_id')->index();
            $table->integer('gateway_id')->index();
            $table->string('external_id')->index();
            $table->string('funding_type')->index();
            $table->string('vault_token')->index();
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
        Schema::dropIfExists('payment_profiles');
    }
}
