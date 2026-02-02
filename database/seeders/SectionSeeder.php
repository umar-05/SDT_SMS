<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Section;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // 1. ONE-TIME CLEANUP: This deletes existing duplicates on Railway 
        // by keeping only the first ID for each course/section name combo.
        Section::whereRaw('id NOT IN (SELECT min(id) FROM (SELECT * FROM sections) as s GROUP BY course_id, name)')->delete();

        // 2. IDEMPOTENT SEEDING:
        $courses = Course::all();
        foreach ($courses as $course) {
            // updateOrCreate checks if a section with this name/course_id exists.
            // If yes, it updates the capacity/schedule. If no, it creates it.
            Section::updateOrCreate(
                [
                    'course_id' => $course->id,
                    'name' => 'Section 01',
                ],
                [
                    'capacity' => 30,
                    'schedule' => 'Mon/Wed 10:00 AM',
                ]
            );
        }
    }
}
