<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Registration;
use App\Models\Course;

class StudentController extends Controller
{

    public function index()
    {
        $studentId = Auth::id();

        $registrations = Registration::with(['course.semester', 'course.lecturer'])
                            ->where('student_id', $studentId)
                            ->get() 
                            ->sortByDesc(function ($registration) {
                                return $registration->course->semester->id ?? 0;
                            });

        $groupedCourses = $registrations->groupBy(function ($registration) {
            return $registration->course->semester->name ?? 'Unknown Semester';
        });

        return view('student.dashboard', compact('groupedCourses'));
    }

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
            // Match these keys to your HTML input 'name' attributes
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|min:8|confirmed',
        ]);
        
        // 1. Update basic User info
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'Current password is incorrect!');
            }
            $user->password = Hash::make($validated['password']);
        }
        
        $user->save();

        // 2. Update or Create the related Profile record
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id], // Search criteria
            [
                'phone_number' => $validated['phone_number'] ?? null, // Database column
                'address' => $validated['address'] ?? null,           // Database column
            ]
        );
        
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
        // Load course with its sections and count of approved registrations for each section
        $course = Course::with(['lecturer', 'semester', 'sections' => function($query) {
            $query->withCount(['registrations' => function($q) {
                $q->where('status', 'approved');
            }]);
        }])->findOrFail($id);
        
        // Check if student is already registered in ANY section of this course
        $isRegistered = Registration::where('student_id', Auth::id())
            ->whereHas('section', function($query) use ($id) {
                $query->where('course_id', $id);
            })->exists();
        
        // This points to your new view: views/student/showcourse.blade.php
        return view('student.showcourse', compact('course', 'isRegistered'));
    }

    public function storeRegistration(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
        ]);

        $studentId = Auth::id();
        $sectionId = $request->section_id;

        // 1. Fetch section with current approved registration count
        $section = \App\Models\Section::withCount(['registrations' => function($q) {
            $q->where('status', 'approved');
        }])->findOrFail($sectionId);

        // 2. Prevent double registration for the same course
        $alreadyRegistered = Registration::where('student_id', $studentId)
            ->whereHas('section', function($q) use ($section) {
                $q->where('course_id', $section->course_id);
            })->exists();

        if ($alreadyRegistered) {
            return back()->with('error', 'You are already registered or have a pending request for this course.');
        }

        // 3. Strict Capacity Check
        if ($section->registrations_count >= $section->capacity) {
            return back()->with('error', 'This section is full. Please select another section.');
        }

        // 4. Create Registration
        Registration::create([
            'student_id' => $studentId,
            'section_id' => $sectionId,
            'status' => 'pending',
        ]);

        return redirect()->route('student.dashboard')
            ->with('success', 'Registration request for ' . $section->name . ' submitted successfully!');
    }
}