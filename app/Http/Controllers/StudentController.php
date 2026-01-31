<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Registration;
use App\Models\Course; // [FIX] Imported Course model

class StudentController extends Controller
{
    /**
     * Dashboard: Shows the student's personal registered courses.
     */
    public function index()
    {
        $registrations = Registration::with('course.semester', 'course.lecturer')
                            ->where('student_id', Auth::id())
                            ->get();

        return view('student.dashboard', compact('registrations'));
    }

    /**
     * Search courses (AJAX or direct).
     */
    public function searchCourses(Request $request)
    {
        $query = $request->get('q');
        
        $courses = Course::where('course_code', 'LIKE', "%{$query}%")
            ->orWhere('title', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get(['id', 'course_code', 'title', 'description']);
        
        return response()->json($courses);
    }

    public function updateRegistration(Request $request, $id)
    {
        $registration = Registration::where('id', $id)
            ->where('student_id', Auth::id())
            ->firstOrFail();
        
        $registration->update([
            'status' => $request->status,
        ]);
        
        return redirect()->route('student.dashboard')
            ->with('success', 'Registration updated successfully!');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|min:8|confirmed',
        ]);
        
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        // Check if phone exists in table before saving, assume yes based on previous code
        // $user->phone = $validated['phone'] ?? $user->phone; 
        
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'Current password is incorrect!');
            }
            $user->password = Hash::make($validated['password']);
        }
        
        $user->save();
        
        return redirect()->route('student.dashboard')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * [FIXED] View All Available Courses
     * Shows all system courses + count of students signed up.
     */
    public function viewCourses()
    {
        // 1. Fetch all courses with lecturer and semester info
        // 2. withCount('registrations') adds a 'registrations_count' attribute to each course
        $courses = Course::with(['lecturer', 'semester'])
            ->withCount(['registrations' => function ($query) {
                // Optionally only count 'approved' students effectively
                $query->where('status', 'approved');
            }])
            ->paginate(10);
        
        return view('student.courses', compact('courses'));
    }

    public function courseDetails($id)
    {
        $course = Course::with(['lecturer', 'semester'])->findOrFail($id);
        
        $isRegistered = Registration::where('student_id', Auth::id())
            ->where('course_id', $id)
            ->exists();
        
        return view('student.course-details', compact('course', 'isRegistered'));
    }
}