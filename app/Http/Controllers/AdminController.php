<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Registration;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // ... dashboard and course management methods remain the same ...

    // --- 3. Amend Registration (Add/Remove students) ---
    public function manageRegistrations(Course $course)
    {
        // Eager load the profile to get the new fields
        $course->load(['registrations.student.profile']);

        $enrolledStudentIds = $course->registrations()->pluck('student_id');
        $availableStudents = User::where('role', 'student')
                                    ->whereNotIn('id', $enrolledStudentIds)
                                    ->get();
                                    
        return view('admin.registrations.manage', compact('course', 'availableStudents'));
    }

    // [NEW] Method to actually process Accept/Reject actions
    public function updateRegistrationStatus(Request $request, Registration $registration)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending'
        ]);

        $registration->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Registration status updated to ' . ucfirst($request->status) . '.');
    }

    public function storeRegistration(Request $request, Course $course)
    {
        $request->validate(['student_id' => 'required|exists:users,id']);

        $currentEnrollment = $course->registrations()->where('status', 'approved')->count();
        
        // If course is full, default to 'pending' (waitlist logic)
        $status = ($currentEnrollment < $course->max_students) ? 'approved' : 'pending';

        Registration::create([
            'course_id' => $course->id,
            'student_id' => $request->student_id,
            'status' => $status
        ]);

        return redirect()->back()->with('success', 'Student added to course.');
    }

    public function destroyRegistration(Registration $registration)
    {
        $registration->delete();
        return redirect()->back()->with('success', 'Registration removed.');
    }
}