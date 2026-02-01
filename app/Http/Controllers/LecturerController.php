<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LecturerController extends Controller
{
    // --- 1. View Assigned Courses ---
    public function dashboard()
    {
        // Only courses assigned to this lecturer
        $courses = Course::where('lecturer_id', Auth::id())
                        ->with('semester')
                        ->get();

        return view('lecturer.dashboard', compact('courses'));
    }

    // --- 2. View Course Details & View Student List ---
    public function showCourse(Course $course)
    {
        // Security Check: Does this course belong to the lecturer?
        if ($course->lecturer_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Eager load registrations and the student data associated with them
        $course->load('registrations.student');

        return view('lecturer.course-details', compact('course'));
    }

    // --- 3. View Student Details ---
    public function showStudent(Course $course, User $student)
    {
        // Security Check: Verify lecturer owns the course AND student is in the course
        if ($course->lecturer_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check if student is actually enrolled in this course
        $isEnrolled = Registration::where('course_id', $course->id)
                                ->where('student_id', $student->id)
                                ->exists();

        if (!$isEnrolled) {
            abort(404, 'Student not enrolled in this course.');
        }

        // Load profile or other academic history if needed
        $student->load('profile'); 

        return view('lecturer.student-details', compact('course', 'student'));
    }

    public function editProfile(Request $request)
    {
        return view('lecturer.profile', [
            'user' => $request->user(),
            'profile' => $request->user()->profile ?? new \App\Models\Profile(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        
        $request->validate([
            'phone_number' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        // Update or create the profile linked to the user
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone_number' => $request->phone_number,
                'address' => $request->address,
            ]
        );

        return back()->with('status', 'profile-updated');
    }



}