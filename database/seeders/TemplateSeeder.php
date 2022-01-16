<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;
use Eloquent;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // make posts table
        Eloquent::unguard();
        $path = 'DB/template_list.sqlite';
        DB::unprepared(file_get_contents($path));
        $this->command->info("Template Default set has been Created!!");
    }
}
