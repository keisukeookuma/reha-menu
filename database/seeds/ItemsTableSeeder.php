<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('items')->truncate();

        DB::table('items')->insert([
            'item_name' => 'sample1',
            'creator' => '田中太郎',
            'caption' => 'sample_caption',
            'img' => '0ba1965d46f0457a7eb57f31ec85e55c1f10871b.png',
            'status' => '1',
        ]);

        DB::table('items')->insert([
            'item_name' => 'sample2',
            'creator' => '田中太郎',
            'caption' => 'sample_caption',
            'img' => '0ba1965d46f0457a7eb57f31ec85e55c1f10871b.png',
            'status' => '1',
        ]);

        DB::table('items')->insert([
            'item_name' => 'sample3',
            'creator' => '田中太郎',
            'caption' => 'sample_caption',
            'img' => '0ba1965d46f0457a7eb57f31ec85e55c1f10871b.png',
            'status' => '1',
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
