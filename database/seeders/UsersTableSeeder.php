<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@tasks.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'user 1',
            'email' => 'user1@tasks.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'user 2',
            'email' => 'user2@tasks.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);

         User::create([
            'name' => 'user 3',
            'email' => 'user3@tasks.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);
    }
}
