<?php

namespace Database\Seeders;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       User::create([
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
        'role' => 'admin',
    ]);

     User::create([
        'name' => 'Customer',
        'email' => 'customer@gmail.com',
        'password' => bcrypt('password'),
        'role' => 'user',
    ]);
    }
}
