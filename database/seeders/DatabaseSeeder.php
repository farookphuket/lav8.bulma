<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Eloquent;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            RoleSeeder::class,
            //WhatnewSeeder::class,
        ]);

        // just to make sure that the pipe table has create after all the main table has created
        $this->create_pip_table();
    }

    public function create_pip_table(){
        

       # Eloquent::unguard();
       # $path = 'DB/user_list.sqlite';
       # DB::unprepared(file_get_contents($path));
       # $this->command->info("User has been Created!!");
        // user role 

        Eloquent::unguard();
        $role_file = 'DB/role_user_list.sqlite'; 
        DB::unprepared(file_get_contents($role_file));
        $this->command->info("Role of User has been Created!!");

    }
}
