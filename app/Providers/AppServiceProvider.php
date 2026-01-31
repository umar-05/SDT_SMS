<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Registration;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share registration data with the modals view automatically
        View::composer('layouts.modals', function ($view) {
            if (Auth::check() && Auth::user()->role === 'student') {
                $registrations = Registration::with('course')
                    ->where('student_id', Auth::id())
                    ->whereIn('status', ['approved', 'pending'])
                    ->get();
                $view->with('registrations', $registrations);
            }
        });
    }
}