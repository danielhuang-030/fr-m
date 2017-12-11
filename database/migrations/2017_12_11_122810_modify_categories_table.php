<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('thumb');
            $table->dropColumn('description');
            $table->dropColumn('order_lv');
            $table->dropUnique('categories_name_unique');

            $table->string('name', 255)->change();
            $table->string('slug', 255)->after('name')->unique();
            $table->integer('sort')->after('slug')->default(100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropColumn('sort');

            $table->string('name', 191)->unique()->change();
            $table->string('thumb')->after('name');
            $table->string('description')->after('thumb')->nullable()->comment('分类的描述');
            $table->tinyInteger('order_lv')->after('description')->default(1);
        });
    }
}
