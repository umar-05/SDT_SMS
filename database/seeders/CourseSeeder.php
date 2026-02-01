<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\User;
use App\Models\Semester;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Get ALL Lecturers (not just the first one)
        $lecturers = User::where('role', 'lecturer')->get();

        // Safety check: If no lecturers exist, stop.
        if ($lecturers->isEmpty()) {
            $this->command->info('No lecturers found! skipping course seeding.');
            return;
        }

        // 2. Define Semesters
        $sem1 = 1; 
        $sem2 = 2;

        $courses = [
            [
                'course_code' => 'SECP3723',
                'title' => 'System Development Technology',
                'description' => 'A course on building modern web applications using MVC frameworks like Laravel.',
                'max_students' => 30,
                'semester_id' => $sem1,
                'credit_hours'=> 3, 
            ],
            [
                'course_code' => 'SECJ1013',
                'title' => 'Programming Technique I',
                'description' => 'Introduction to C++ programming, problem-solving, and basic algorithms.',
                'max_students' => 40,
                'semester_id' => $sem1,
                'credit_hours'=> 3, 
            ],
            [
                'course_code' => 'SECI1013',
                'title' => 'Discrete Structure',
                'description' => 'Mathematical structures fundamental to computer science: logic, sets, and graph theory.',
                'max_students' => 35,
                'semester_id' => $sem1,
                'credit_hours'=> 3, 
            ],
            [
                'course_code' => 'SECD2523',
                'title' => 'Database Systems',
                'description' => 'Design and implementation of relational databases, SQL queries, and normalization.',
                'max_students' => 25,
                'semester_id' => $sem2,
                'credit_hours'=> 3, 
            ],
            [
                'course_code' => 'SECR3213',
                'title' => 'Network Communications',
                'description' => 'Understanding OSI models, TCP/IP protocols, and network routing fundamentals.',
                'max_students' => 30,
                'semester_id' => $sem2,
                'credit_hours'=> 3, 
            ],
            [
                'course_code' => 'SECV2113',
                'title' => 'Human Computer Interaction',
                'description' => 'Study of user interface design, usability testing, and UX principles.',
                'max_students' => 28,
                'semester_id' => $sem2,
                'credit_hours'=> 3, 
            ],
            [
                'course_code' => 'SECJ3553',
                'title' => 'Artificial Intelligence',
                'description' => 'Overview of AI concepts including machine learning, neural networks, and robotics.',
                'max_students' => 20,
                'semester_id' => $sem2,
                'credit_hours'=> 3, 
            ],
            [
                'course_code' => 'SECP4112',
                'title' => 'Final Year Project 1',
                'description' => 'Research methodology and proposal defense for final year undergraduate projects.',
                'max_students' => 50,
                'semester_id' => $sem1,
                'credit_hours'=> 2, 
            ],
        ];

        foreach ($courses as $courseData) {
            // Assign a RANDOM lecturer from the list we fetched
            $courseData['lecturer_id'] = $lecturers->random()->id;

            Course::firstOrCreate(
                ['course_code' => $courseData['course_code']], 
                $courseData
            );
        }
    }
}