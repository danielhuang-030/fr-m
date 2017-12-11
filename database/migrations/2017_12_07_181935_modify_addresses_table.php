<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addresses', function (Blueprint $table) {
            DB::statement('ALTER TABLE addresses DROP FOREIGN KEY `addresses_user_id_foreign`');
            DB::statement('DROP INDEX addresses_user_id_foreign ON addresses');

            $table->dropColumn('name');
            $table->dropColumn('province');
            $table->dropColumn('detail_address');
            $table->dropColumn('is_default');

            $table->string('first_name', 50)->after('user_id');
            $table->string('last_name', 50)->after('first_name');
            $table->char('country', 5)->after('last_name');
            $table->integer('state_id')->after('country');
            $table->string('city', 50)->after('state')->change();
            $table->string('addr', 255)->after('city')->nullable();
            $table->string('zipcode', 10)->after('addr');
            $table->string('phone', 20)->after('zipcode')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('country');
            $table->dropColumn('state_id');
            $table->dropColumn('addr');
            $table->dropColumn('zipcode');

            $table->string('name')->after('user_id')->comment('收货人名字');
            $table->string('phone')->after('name')->comment('收货人手机号码')->change();

            $table->string('province')->after('phone')->nullable()->comment('省份');
            $table->string('city')->after('province')->nullable()->comment('城市')->change();
            $table->string('detail_address')->after('city')->comment('详细的收货地址');
            $table->tinyInteger('is_default')->after('detail_address')->default(0)->comment('是否是默认收货地址');

            $table->foreign('user_id')->references('id')->on('users');
        });
    }
}
