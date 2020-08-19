<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('templates')->truncate();

        DB::table('templates')->insert([
            'user_id' => '1',
            'item_id' => '1',
            'template_name' => 'sample',
        ]);

        DB::table('templates')->insert([
            'user_id' => '1',
            'item_id' => '2',
            'template_name' => 'sample',
        ]);

        DB::table('templates')->insert([
            'user_id' => '1',
            'item_id' => '3',
            'template_name' => 'sample',
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
