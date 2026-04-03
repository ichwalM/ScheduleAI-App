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
            ['email' => 'admin@scheduleai.com'],
            [
                'name'     => 'Admin',
                'email'    => 'admin@scheduleai.com',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        // Demo student account
        User::firstOrCreate(
            ['email' => 'student@scheduleai.com'],
            [
                'name'     => 'Demo Student',
                'email'    => 'student@scheduleai.com',
                'password' => Hash::make('password'),
                'role'     => 'student',
            ]
        );
    }
}
