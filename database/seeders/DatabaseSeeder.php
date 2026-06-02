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
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'royhandaffa125@gmail.com'],
            [
                'name' => 'Royhan',
                'password' => 'superadmin',
                'role' => 'superadmin'
            ]
        );

        User::firstOrCreate(
            ['email' => 'daffaroyhan525@gmail.com'],
            [
                'name' => 'Daffa',
                'password' => 'boskubabi',
                'role' => 'admin'
            ]
        );

        User::firstOrCreate(
            ['email' => 'boedakoding@gmail.com'],
            [
                'name' => 'Superadmin',
                'password' => 'Boedakoding.persada',
                'role' => 'superadmin'
            ]
        );
    }
}
