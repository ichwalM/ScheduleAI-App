<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin account
        User::firstOrCreate(
            ['email' => 'aidrophunter093@gmail.com'],
            [
                'name'     => 'Admin',
                'email'    => 'aidrophunter093@gmail.com',
                'password' => Hash::make('password123'),
                'role'     => 'admin',
            ]
        );
    }
}
