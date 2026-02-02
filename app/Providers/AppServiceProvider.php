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
        // 1. Force HTTPS in production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
            
            // Auto-seed on first run (with safety check)
            try {
                if (DB::table('semesters')->count() === 0) {
                    Log::info('Running seeder...');
                    Artisan::call('db:seed', ['--force' => true]);
                    Log::info('Seeder completed');
                }
            } catch (\Exception $e) {
                // Database not ready yet (during build), skip
                Log::info('Database not ready, skipping seeder check');
            }
        }

        // 2. Share registration data
        View::composer('layouts.modals', function ($view) {
            if (Auth::check() && Auth::user()->role === 'student') {
                $registrations = Registration::with('section.course')
                    ->where('student_id', Auth::id())
                    ->whereIn('status', ['approved', 'pending'])
                    ->get();
                    
                $view->with('registrations', $registrations);
            }
        });
    }
}
