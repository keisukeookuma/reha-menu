<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SearchWordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('search_words')->truncate();

        DB::table('search_words')->insert([
            'item_id' => '1',
            'search_word' => '肉',
        ]);

        DB::table('search_words')->insert([
            'item_id' => '2',
            'search_word' => '魚',
        ]);

        DB::table('search_words')->insert([
            'item_id' => '3',
            'search_word' => '野菜',
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
