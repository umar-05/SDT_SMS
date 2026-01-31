<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Registration;

class AdminController extends Controller
{
    public function index()
    {
        // Gather stats for the admin dashboard
        $stats = [
            'total_students' => User::where('role', 'student')->count(),
            'total_lecturers' => User::where('role', 'lecturer')->count(),
            'total_courses' => Course::count(),
            'pending_registrations' => Registration::where('status', 'pending')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}