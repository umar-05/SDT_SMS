<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Registration;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 1. Force HTTPS in production to prevent Mixed Content errors on Railway
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
            
            // Auto-seed database on first run
            if (DB::table('semesters')->count() === 0) {
                Log::info('Database empty, running seeder...');
                Artisan::call('db:seed', ['--force' => true]);
                Log::info('Seeder completed: ' . Artisan::output());
            }
        }

        // 2. Share registration data with modals view
        View::composer('layouts.modals', function ($view) {
            if (Auth::check() && Auth::user()->role === 'student') {
                // FIXED: Querying through section to get course details
                $registrations = Registration::with('section.course')
                    ->where('student_id', Auth::id())
                    ->whereIn('status', ['approved', 'pending'])
                    ->get();
                    
                $view->with('registrations', $registrations);
            }
        });
    }
}
