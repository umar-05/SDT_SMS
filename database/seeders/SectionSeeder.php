<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Section;

class SectionSeeder extends Seeder
{
    public function run()
    {
        // STEP 1: WIPE ALL EXISTING SECTIONS FIRST
        // This is the only way to be 100% sure the duplicates are gone
        // since you don't have terminal access to tinker.
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Section::truncate(); 
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // STEP 2: RE-CREATE THEM CLEANLY
        $courses = Course::all();
        foreach ($courses as $course) {
            Section::create([
                'course_id' => $course->id,
                'name'      => 'Section 01',
                'capacity'  => 30,
                'schedule'  => 'Mon/Wed 10:00 AM',
                'room'      => 'TBA'
            ]);
        }
    }
}
