<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile; // Ensure you import the Profile model
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password123');

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
        $lecturers = [
            ['email' => 'lecturer@example.com', 'name' => 'Dr. Smith'],
            ['email' => 'hidayah@example.com', 'name' => 'Dr. Hidayah'],
            ['email' => 'prof.ali@example.com', 'name' => 'Prof. Ali'],
            ['email' => 'dr.tan@example.com', 'name' => 'Dr. Tan'],
        ];

        foreach ($lecturers as $lecturerData) {
            User::firstOrCreate(
                ['email' => $lecturerData['email']],
                ['name' => $lecturerData['name'], 'password' => $password, 'role' => 'lecturer']
            );
        }


        $students = [
            [
                'name' => 'John Student',
                'email' => 'student@example.com',
                'matric' => 'A21CS0001',
                'prog' => 'Bachelor of Computer Science (Software Engineering)'
            ],
            [
                'name' => 'Umar',
                'email' => 'umar@example.com',
                'matric' => 'A21CS0045',
                'prog' => 'Bachelor of Computer Science (Data Engineering)'
            ],
            [
                'name' => 'Sarah Ahmed',
                'email' => 'sarah@example.com',
                'matric' => 'A21CS0089',
                'prog' => 'Bachelor of Computer Science (Software Engineering)'
            ],
            [
                'name' => 'Ahmad Razak',
                'email' => 'ahmad@example.com',
                'matric' => 'A21CS0112',
                'prog' => 'Bachelor of Computer Science (Network & Security)'
            ],
            [
                'name' => 'Mei Ling',
                'email' => 'mei@example.com',
                'matric' => 'A21CS0156',
                'prog' => 'Bachelor of Computer Science (Graphics & Multimedia)'
            ],
            [
                'name' => 'Raju Subramaniam',
                'email' => 'raju@example.com',
                'matric' => 'A21CS0201',
                'prog' => 'Bachelor of Computer Science (Software Engineering)'
            ],
        ];

        foreach ($students as $studentData) {
            // 1. Create the User
            $user = User::firstOrCreate(
                ['email' => $studentData['email']],
                ['name' => $studentData['name'], 'password' => $password, 'role' => 'student']
            );

            // 2. Create the associated Profile with Phone, Address, Matric, and Programme
            // This ensures these fields are populated only at the database level
            Profile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'matric_number' => $studentData['matric'],
                    'programme'     => $studentData['prog'],
                    'phone_number'  => '012-3456789', // Default placeholder
                    'address'       => 'UTM Residential Hall, Johor Bahru', // Default placeholder
                ]
            );
        }
    }
}