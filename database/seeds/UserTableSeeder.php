<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendPassword;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $name = env('USER_SEED_NAME', false);
        $email = env('USER_SEED_EMAIL', false);
        //$password = str_random(8);
        $password = 'test123';
        
        $role_admin = Role::where('name', 'administrator')->first();
        
        $admin = new User();
        $admin->name = $name;
        $admin->email = $email;
        $admin->password = bcrypt($password);
        $admin->save();
        $admin->roles()->attach($role_admin);
        
        // Setup email data and send password to initial admin
        $email_details = array(
        "name" => $name,
        "password" => $password
        );
        Mail::to($email)->send(new SendPassword($email_details));
    }
}