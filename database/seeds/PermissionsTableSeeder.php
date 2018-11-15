<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = array(
            ['name' => 'view user profile'],
            ['name' => 'view private user details'],
            ['name' => 'edit private user details'],
            ['name' => 'resolve trade dispute'],
        );

        foreach ($permissions as $permission){
            if(!Permission::where('name', $permission)->first()){
                Permission::create($permission);
            }
        }

    }
}
