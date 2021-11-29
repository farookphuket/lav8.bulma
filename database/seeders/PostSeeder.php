<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Eloquent;
use DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // make posts table
        Eloquent::unguard();
        $path = 'DB/post_list.sqlite';
        DB::unprepared(file_get_contents($path));
        $this->command->info("Post has been Created!!");
    }
}
