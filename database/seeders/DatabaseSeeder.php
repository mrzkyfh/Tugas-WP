<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kategori;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'Administrator',
            'email' => 'admin@admin.com',
            'role' => '1',
            'status' => 1,
            'hp' => '0812345678901',
            'password' => bcrypt('passwordlima'),
        ]);
        User::create([
            'nama' => 'Sopian Aji',
            'email' => 'sopianaji@admin.com',
            'role' => '0',
            'status' => 1,
            'hp' => '0812345678902',
            'password' => bcrypt('P@55word'),
        ]);

        #data kategori
        Kategori::create([
            'nama_kategori' => 'Smartphone',
        ]);
        Kategori::create([
            'nama_kategori' => 'Laptop & Komputer',
        ]);
        Kategori::create([
            'nama_kategori' => 'Wearable',
        ]);
        Kategori::create([
            'nama_kategori' => 'Aksesoris Audio',
        ]);
        Kategori::create([
            'nama_kategori' => 'Aksesoris Handphone',
        ]);
        Kategori::create([
            'nama_kategori' => 'Aksesoris Komputer',
        ]);
        Kategori::create([
            'nama_kategori' => 'Service & Perbaikan',
        ]);
        Kategori::create([
            'nama_kategori' => 'Smart Home',
        ]);
        Kategori::create([
            'nama_kategori' => 'Gaming',
        ]);
    }
}
