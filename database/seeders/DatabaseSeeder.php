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
            PostSeeder::class,
            TagSeeder::class,
            VisitorSeeder::class,
            WhatnewSeeder::class,
        ]);

        // just to make sure that the pipe table has create after all the main table has created
        $this->create_pip_table();
    }

    public function create_pip_table(){
        
        /*
         * the pip table have to create after all main table has created
         * */

        Eloquent::unguard();
        $role_file = 'DB/role_user_list.sqlite'; 
        DB::unprepared(file_get_contents($role_file));
        $this->command->info("Role of User has been Created!!");


        Eloquent::unguard();
        $post_tag_file = 'DB/post_tag_list.sqlite'; 
        DB::unprepared(file_get_contents($post_tag_file));
        $this->command->info("Post Tag Link has been Created!!");

    }
}
