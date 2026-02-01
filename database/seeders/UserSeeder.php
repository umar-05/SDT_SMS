<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password123'); // Shared password for faster seeding

        // ================= IT STAFF =================
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User', 'password' => $password, 'role' => 'it_staff']
        );

        User::firstOrCreate(
            ['email' => 'support@example.com'],
            ['name' => 'System Support', 'password' => $password, 'role' => 'it_staff']
        );

        // ================= LECTURERS =================
        User::firstOrCreate(
            ['email' => 'lecturer@example.com'],
            ['name' => 'Dr. Smith', 'password' => $password, 'role' => 'lecturer']
        );

        User::firstOrCreate(
            ['email' => 'hidayah@example.com'],
            ['name' => 'Dr. Hidayah', 'password' => $password, 'role' => 'lecturer']
        );

        User::firstOrCreate(
            ['email' => 'prof.ali@example.com'],
            ['name' => 'Prof. Ali', 'password' => $password, 'role' => 'lecturer']
        );

        User::firstOrCreate(
            ['email' => 'dr.tan@example.com'],
            ['name' => 'Dr. Tan', 'password' => $password, 'role' => 'lecturer']
        );

        // ================= STUDENTS =================
        User::firstOrCreate(
            ['email' => 'student@example.com'],
            ['name' => 'John Student', 'password' => $password, 'role' => 'student']
        );

        User::firstOrCreate(
            ['email' => 'umar@example.com'],
            ['name' => 'Umar', 'password' => $password, 'role' => 'student']
        );

        User::firstOrCreate(
            ['email' => 'sarah@example.com'],
            ['name' => 'Sarah Ahmed', 'password' => $password, 'role' => 'student']
        );

        User::firstOrCreate(
            ['email' => 'ahmad@example.com'],
            ['name' => 'Ahmad Razak', 'password' => $password, 'role' => 'student']
        );

        User::firstOrCreate(
            ['email' => 'mei@example.com'],
            ['name' => 'Mei Ling', 'password' => $password, 'role' => 'student']
        );

        User::firstOrCreate(
            ['email' => 'raju@example.com'],
            ['name' => 'Raju Subramaniam', 'password' => $password, 'role' => 'student']
        );
    }
}