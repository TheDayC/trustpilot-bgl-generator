<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $role_employee = new Role();
        $role_employee->name = 'user';
        $role_employee->description = 'Users have the lowest permissions possible.';
        $role_employee->save();
        
        $role_employee = new Role();
        $role_employee->name = 'editor';
        $role_employee->description = 'Editors can create payloads.';
        $role_employee->save();
        
        $role_employee = new Role();
        $role_employee->name = 'administrator';
        $role_employee->description = 'Admins have superpowers.';
        $role_employee->save();
    }
}