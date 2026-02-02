<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Section;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        $courses = Course::all();

        foreach ($courses as $course) {
            Section::updateOrCreate(
                [
                    // unique identity of a section
                    'course_id' => $course->id,
                    'name'      => 'Section 01',
                ],
                [
                    'capacity' => 30,
                    'schedule' => 'Mon/Wed 10:00 AM',
                    'room'     => 'Online',
                ]
            );
        }
    }
}
