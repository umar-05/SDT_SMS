<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the seeders in the correct order
        // 1. Semesters (Courses need semesters)
        $this->call(SemesterSeeder::class);

        // 2. Users (Courses need lecturers)
        $this->call(UserSeeder::class);

        // 3. Courses (Depend on Semesters and Users)
        $this->call(CourseSeeder::class);

        $this->call(SectionSeeder::class);
    }
}