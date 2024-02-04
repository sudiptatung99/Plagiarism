<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = [
            'name'=>'Admin',
            'email'=>'admin@admin.com',
            'password' =>bcrypt('password')
        ];
        Admin::create($admin);

        // $user = [
        //     'name'=>'user',
        //     'email'=>'user@gmail.com',
        //     'role'=>'Expert',
        //     'password' =>bcrypt('password')
        // ];
        // User::create($user);
    }
}
