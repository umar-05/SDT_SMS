<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;   // <--- ADD THIS
use App\Models\User;     // <--- ADD THIS
use App\Models\Semester; // <--- ADD THIS

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::create([
        'course_code' => 'SECP3723',
        'title' => 'System Development Technology',
        'description' => 'A course on building modern web applications.',
        'max_students' => 30,
        'lecturer_id' => 1, // Assumes you have a user with ID 1
        'semester_id' => 1, // Assumes you have a semester with ID 1
    ]);
    }
}
