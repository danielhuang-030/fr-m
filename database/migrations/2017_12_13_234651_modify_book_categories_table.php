<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyBookCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('book_categories', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->primary(['book_id', 'category_id']);
            $table->dropColumn('updated_at');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('book_categories', function (Blueprint $table) {
            DB::statement('ALTER TABLE book_categories DROP PRIMARY KEY');
            $table->increments('id')->first();
            $this->timestamp('updated_at', $precision)->nullable();
        });

    }
}
