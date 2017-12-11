<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('bwb_id')->unsigned()->index();
            $table->string('isbn10', 10)->index();
            $table->string('isbn13', 13)->index();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->text('description');
            $table->string('format', 20)->index();
            $table->decimal('weight', 10, 2);
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
        Schema::dropIfExists('books');
    }
}
