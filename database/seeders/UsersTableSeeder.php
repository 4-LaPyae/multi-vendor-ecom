<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                "name"=>"Admin",
                "username"=>"admin",
                "email"=>"admin@gmail.com",
                "password"=>Hash::make('admin123'),
                "role"=>"admin",
                "status"=>"active"
            ],
            [
                "name"=>"Vendor",
                "username"=>"vendor",
                "email"=>"vendor@gmail.com",
                "password"=>Hash::make('vendor123'),
                "role"=>"vendor",
                "status"=>"active"
            ],
            [
                "name"=>"User",
                "username"=>"user",
                "email"=>"user@gmail.com",
                "password"=>Hash::make('user123'),
                "role"=>"user",
                "status"=>"active"
            ]

        ]);
    }
}
