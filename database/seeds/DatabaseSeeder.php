<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminsTableSeeder::class);

        // permission and roles
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);

        // Assign role permissions
        $this->call(PermissionsRolesTableSeeder::class);

        // states
        $this->call(StatesTableSeeder::class);
    }
}
