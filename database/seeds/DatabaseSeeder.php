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
      // Role seeder runs before user seeder
      $this->call(RoleTableSeeder::class);

      // User seeder will use roles created above.
      $this->call(UserTableSeeder::class);
    }
}