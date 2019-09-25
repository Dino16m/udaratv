<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'=>'viktor',
            'password'=>Hash::make('viktor'),
            'email'=> 'nwoguuchenna88@gmail.com'
        ]);
        DB::table('users')->insert([
            'name'=>'dino16m',
            'password'=>Hash::make('dino16m'),
            'email'=> 'anselem16m@gmail.com'
        ]);
    }
}
