<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Semester;

class SemesterSeeder extends Seeder
{
    public function run(): void
    {
        // Current Semester
        Semester::create([
            'name' => 'Semester 1 2025/2026',
            'is_current' => true,
        ]);

        // Previous Semester
        Semester::create([
            'name' => 'Semester 2 2024/2025',
            'is_current' => false,
        ]);
    }
}