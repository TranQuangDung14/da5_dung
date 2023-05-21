<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

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
            'name' => 'Quang Dũng',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123'),
            'role'  =>'staff',
            // 'password' => bcrypt('123'),
        ]);
        DB::table('users')->insert([
            'name' => 'Bích Quyên',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('123'),
            'role'  =>'customer',
            // 'password' => bcrypt('123'),
        ]);
        DB::table('users')->insert([
            'name' => 'Quang Dũng',
            'email' => 'dung@gmail.com',
            'password' => Hash::make('123'),
            'role'  =>'customer',
            // 'password' => bcrypt('123'),
        ]);
        DB::table('users')->insert([
            'name' => 'Quang Dũng',
            'email' => 'quangstsdung@gmail.com',
            'password' => Hash::make('123'),
            'role'  =>'customer',
            // 'password' => bcrypt('123'),
        ]);
    }
}
