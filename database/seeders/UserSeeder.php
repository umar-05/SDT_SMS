<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create an IT Staff (Admin)
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'it_staff',
        ]);

        // 2. Create a Lecturer
        User::create([
            'name' => 'Dr. Smith',
            'email' => 'lecturer@example.com',
            'password' => Hash::make('password123'),
            'role' => 'lecturer',
        ]);

        // 3. Create a Student
        User::create([
            'name' => 'John Student',
            'email' => 'student@example.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
        ]);
    }
}