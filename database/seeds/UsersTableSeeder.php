<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->insert([
            'name' => '吉岡里帆',
            'email' => Str::random(10).'@gmail.com',
            'password' => bcrypt('secret'),
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
