<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {    
        Log::info('===== DATABASE SEEDER STARTED =====');

        // Order matters for Foreign Key constraints
        $this->call([
            SemesterSeeder::class,
            UserSeeder::class,
            CourseSeeder::class,
            SectionSeeder::class, // This must be updated to use updateOrCreate
        ]);

        Log::info('===== DATABASE SEEDER COMPLETED =====');
    }
}
