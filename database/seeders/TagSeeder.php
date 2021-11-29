<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Eloquent;
use DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // make tags table
        Eloquent::unguard();
        $path = 'DB/tag_list.sqlite';
        DB::unprepared(file_get_contents($path));
        $this->command->info("Tag has been Created!!");
    }
}
