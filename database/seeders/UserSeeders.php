<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
        ]);

        User::create([
            'name' => 'IT Staff User',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_IT_STAFF,
        ]);

        User::create([
            'name' => 'Viewer User',
            'email' => 'viewer@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_VIEWER,
        ]);
    }
}