<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'states.json');
        $data = json_decode($data, true);

        DB::table('states')->insert($data);
    }
}
