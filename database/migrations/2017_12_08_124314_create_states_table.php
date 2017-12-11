<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Database\Seeds;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 50);
            $table->char('code', 3);
        });

        // seeds
        $data = file_get_contents(__DIR__ . '/../seeds/data/states.json');
        $data = json_decode($data, true);
        DB::table('states')->insert($data);

        // drop table
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('cities');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('states');
    }
}
