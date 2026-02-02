<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $courses = \App\Models\Course::all();
        foreach ($courses as $course) {
            \App\Models\Section::create([
                'course_id' => $course->id,
                'name' => 'Section 01',
                'capacity' => 30,
                'schedule' => 'Mon/Wed 10:00 AM',
            ]);
        }
    }
}
