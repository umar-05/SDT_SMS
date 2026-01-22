<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Registration; // Don't forget this import!

class StudentController extends Controller
{
    public function index()
    {
        // Fetch registrations for the currently logged-in student
        // and include the 'course' details so we can show the title
        $registrations = Registration::with('course')
                            ->where('student_id', Auth::id())
                            ->get();

        return view('student.dashboard', compact('registrations'));
    }
}