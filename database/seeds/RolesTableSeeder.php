<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!Role::where('name', 'admin')->first()){
            $role = Role::create([
                'name' => 'admin',
                'priority' => 4
            ]);

            $role->syncPermissions([
                'view user profile',
                'view private user details',
                'edit private user details',
                'resolve trade dispute',
            ]);
        }

        if(!Role::where('name', 'super_moderator')->first()) {
            $role = Role::create([
                'name' => 'super_moderator',
                'priority' => 3
            ]);

            $role->syncPermissions([
                'view user profile',
                'view private user details',
                'edit private user details',
                'resolve trade dispute'
            ]);
        }

        if(!Role::where('name', 'moderator')->first()) {
            $role = Role::create([
                'name' => 'moderator',
                'priority' => 2
            ]);

            $role->syncPermissions([
                'view user profile',
                'view private user details',
                'resolve trade dispute'
            ]);
        }

        if(!Role::where('name', 'user')->first()) {
            $role = Role::create([
                'name' => 'user',
                'priority' => 1
            ]);

            $role->syncPermissions([
                'view user profile'
            ]);
        }
    }
}
