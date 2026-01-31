<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    /**
     * Requirement 5c: Search course.
     * Requirement 5a: Register courses.
     */
    public function index(Request $request)
    {
        $query = Course::with('lecturer', 'semester');

        // Search Logic
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('course_code', 'like', '%' . $searchTerm . '%');
            });
        }

        $courses = $query->get();
        
        return view('student.register', compact('courses'));
    }

    public function create()
    {
        // Redirect to index as that's where the list logic lives now
        return redirect()->route('student.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $course = Course::findOrFail($request->course_id);
        $studentId = Auth::id();

        // 1. Duplicate Check
        $existing = Registration::where('student_id', $studentId)
                                ->where('course_id', $course->id)
                                ->exists();

        if ($existing) {
            return redirect()->back()->with('error', 'You are already registered or pending for this course.');
        }

        // 2. Requirement 8g: Auto-approval Logic
        $currentApproved = Registration::where('course_id', $course->id)
                                    ->where('status', 'approved')
                                    ->count();

        if ($currentApproved < $course->max_students) {
            $status = 'approved';
            $msg = 'Registration successful! You are enrolled.';
        } else {
            $status = 'pending';
            $msg = 'Course is full. Your registration is pending approval.';
        }

        Registration::create([
            'student_id' => $studentId,
            'course_id' => $course->id,
            'status' => $status,
        ]);

        return redirect()->route('student.register')->with('success', $msg);
    }

    public function destroy($id)
    {
        $registration = Registration::findOrFail($id);

        if ($registration->student_id !== Auth::id()) {
            abort(403);
        }

        $registration->delete();

        return redirect()->back()->with('success', 'Registration cancelled.');
    }
}