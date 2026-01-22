<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
/**
     * Display a listing of available courses for registration.
     */
    public function index()
    {
        // Fetch courses that aren't full yet (Requirement 38 logic)
        $courses = Course::with('lecturer', 'semester')->get();
        
        return view('student.register', compact('courses'));
    }

    public function create()
    {
        // Fetch all courses to display on the registration page
        $courses = Course::all();
        
        return view('student.register', compact('courses'));
    }

    /**
     * Store a new registration in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        // Create the registration record using the 3NF link table
        Registration::create([
            'student_id' => Auth::id(),
            'course_id' => $request->course_id,
            'status' => 'pending', // Will be updated by Admin or Auto-approval logic
        ]);

        return redirect()->route('student.register')->with('success', 'Registration submitted!');
    }

    public function destroy($id)
    {
        // 1. Find the registration
        $registration = \App\Models\Registration::findOrFail($id);

        // 2. Security Check: Ensure the logged-in student owns this registration
        if ($registration->student_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // 3. Delete the record
        $registration->delete();

        // 4. Redirect back with success message
        return redirect()->back()->with('success', 'Course registration cancelled successfully.');
    }

}
