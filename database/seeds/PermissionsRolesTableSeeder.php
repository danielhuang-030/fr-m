<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // all permissions
        $admin = Role::where('name', 'admin')->first();
        $this->givePermission($admin, [
            'add-manager', 'update-manager', 'delete-manager',
            'add-category', 'update-category', 'delete-category',
            'add-book', 'update-book', 'delete-book',
            'add-user', 'update-user', 'delete-user',
        ]);

        $admin = Role::where('name', 'manager')->first();
        $this->givePermission($admin, [
            'add-category', 'update-category', 'delete-category',
            'add-book', 'update-book', 'delete-book',
            'add-user', 'update-user', 'delete-user',
        ]);

        $admin = Role::where('name', 'category-manager')->first();
        $this->givePermission($admin, [
            'add-category', 'update-category', 'delete-category',
        ]);

        $admin = Role::where('name', 'book-manager')->first();
        $this->givePermission($admin, [
            'add-book', 'update-book', 'delete-book',
        ]);

        $admin = Role::where('name', 'user-manager')->first();
        $this->givePermission($admin, [
            'add-user', 'update-user', 'delete-user',
        ]);
    }

    protected function givePermission($user, array $permissions)
    {
        foreach ($permissions as $permission) {
            $user->givePermissionTo($permission);
        }
    }
}
