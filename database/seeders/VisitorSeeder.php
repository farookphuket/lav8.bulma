<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Eloquent;
use DB;
class VisitorSeeder extends Seeder
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
        $path = 'DB/visitor_list.sqlite';
        DB::unprepared(file_get_contents($path));
        $this->command->info("Visitor has been Created!!");
    }
}
