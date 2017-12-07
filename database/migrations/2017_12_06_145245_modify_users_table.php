<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name', 255)->change();
            $table->string('email', 255)->change();
            $table->string('avatar')->nullable()->change();

            $table->dropColumn('sex');
            $table->dropColumn('github_id');
            $table->dropColumn('github_name');
            $table->dropColumn('qq_id');
            $table->dropColumn('qq_name');
            $table->dropColumn('weibo_id');
            $table->dropColumn('weibo_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name', 50)->change();
            $table->string('email', 50)->change();
            // $table->string('avatar')->nullable(false)->change();

            $table->tinyInteger('sex')->after('name')->default(1)->commen('1为男，0为女');
            $table->integer('github_id')->after('login_count')->nullable()->index()->comment('github第三方登录的ID');
            $table->string('github_name')->after('github_id')->nullable()->comment('github第三方登录的用户名');
            $table->string('qq_id')->after('github_name')->nullable()->index();
            $table->string('qq_name')->after('qq_id')->nullable();
            $table->string('weibo_id')->after('qq_name')->nullable()->index();
            $table->string('weibo_name')->after('weibo_id')->nullable();
        });
    }
}
