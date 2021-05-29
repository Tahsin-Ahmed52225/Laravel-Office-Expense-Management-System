<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "TDG Admin",
            'email' => "admin@tdg.com",
            'password' => Hash::make('password'),
            'image_path' => 'none',
            'verification_code' => 'GODmodeActived',
            'stage' => '1',
            'role' => 'admin',
            'is_verified' => '1',
            'designation' => 'High Command',
            'department' => 'All',
            'number' => "11223344",
            'password' =>   Hash::make("11223344"),
            'salary' => '100000'

        ]);
    }
}
