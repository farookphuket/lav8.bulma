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
            CategorySeeder::class,
            PostSeeder::class,
            CommentSeeder::class,
            ReplySeeder::class,
            ReadSeeder::class,
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

        Eloquent::unguard();
        $post_category_file = 'DB/post_category_link.sqlite'; 
        DB::unprepared(file_get_contents($post_category_file));
        $this->command->info("Post Category Link has been Created!!");

        Eloquent::unguard();
        $post_read_file = 'DB/post_read_list.sqlite'; 
        DB::unprepared(file_get_contents($post_read_file));
        $this->command->info("Post Read Link has been Created!!");


        // comment link to post
        Eloquent::unguard();
        $comment_post_file = 'DB/post_comment_link.sqlite'; 
        DB::unprepared(file_get_contents($comment_post_file));
        $this->command->info("Post Comment Link has been Created!!");


        // reply link to comment
        Eloquent::unguard();
        $comment_reply_file = 'DB/comment_reply_link.sqlite'; 
        DB::unprepared(file_get_contents($comment_reply_file));
        $this->command->info("Reply Comment Link has been Created!!");

    }
}
