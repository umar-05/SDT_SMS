<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LecturerController extends Controller
{
    
    public function dashboard()
    {

        $courses = Course::where('lecturer_id', Auth::id())
                        ->with('semester')
                        ->get();

        return view('lecturer.dashboard', compact('courses'));
    }

    public function showCourse(Course $course)
    {
        if ($course->lecturer_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Load registrations THROUGH sections
        $course->load(['sections.registrations.student.profile']);

        return view('lecturer.course-details', compact('course'));
    }

    
    public function showStudent(Course $course, User $student)
    {
        if ($course->lecturer_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check enrollment by looking at sections belonging to this course
        $isEnrolled = Registration::where('student_id', $student->id)
            ->whereHas('section', function($query) use ($course) {
                $query->where('course_id', $course->id);
            })->exists();

        if (!$isEnrolled) {
            abort(404, 'Student not enrolled in this course.');
        }

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