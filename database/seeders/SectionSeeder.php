<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Section;
use Illuminate\Support\Facades\DB; // <--- THIS WAS MISSING

class SectionSeeder extends Seeder
{
    public function run()
    {
        // 1. DISABLE FOREIGN KEYS SO WE CAN TRUNCATE SAFELY
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 2. WIPE THE TABLE CLEAN (Removes all duplicates)
        Section::truncate();

        // 3. RE-ENABLE FOREIGN KEYS
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 4. RE-CREATE SECTIONS (Cleanly)
        $courses = Course::all();
        foreach ($courses as $course) {
            Section::create([
                'course_id' => $course->id,
                'name'      => 'Section 01',
                'capacity'  => 30,
                'schedule'  => 'Mon/Wed 10:00 AM',
                'room'      => 'Online' // Added room to prevent null error
            ]);
        }
    }
}
