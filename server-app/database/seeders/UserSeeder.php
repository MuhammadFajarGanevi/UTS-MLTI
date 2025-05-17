<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin'),
                'email_verified_at' => now(),
            ]
        );

        // Regular User
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'User',
                'password' => Hash::make('user'),
                'email_verified_at' => now(),
            ]
        );

        // Worker
        User::updateOrCreate(
            ['email' => 'worker@example.com'],
            [
                'name' => 'Worker',
                'password' => Hash::make('worker'),
                'email_verified_at' => now(),
            ]
        );
    }
}
