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

        User::create([
            'name' => 'Royhan',
            'email' => 'royhandf@gmail.com',
            'password' => 'superadmin',
            'role' => 'superadmin'
        ]);

        User::create([
            'name' => 'Daffa',
            'email' => 'daffaroyhan525@gmail.com',
            'password' => 'boskubabi',
            'role' => 'admin'
        ]);
    }
}
