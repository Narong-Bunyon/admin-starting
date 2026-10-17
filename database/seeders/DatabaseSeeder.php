<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default Admin account
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'System Admin',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'last_login_at' => now(),
            ]
        );

        // Demo User 1
        \App\Models\User::updateOrCreate(
            ['email' => 'alice@example.com'],
            [
                'name' => 'Alice Demo',
                'password' => bcrypt('password123'),
                'role' => 'user',
                'last_login_at' => now()->subHours(2),
            ]
        );

        // Demo User 2
        \App\Models\User::updateOrCreate(
            ['email' => 'bob@example.com'],
            [
                'name' => 'Bob Demo',
                'password' => bcrypt('password123'),
                'role' => 'user',
                'last_login_at' => now()->subMinutes(30),
            ]
        );
    }
}
