<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Registration;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // --- 1. Dashboard View (RE-ADDED) ---
    public function dashboard()
    {
        $totalStudents = User::where('role', 'student')->count();
        $totalLecturers = User::where('role', 'lecturer')->count();
        $totalCourses = Course::count();
        $pendingRegistrations = Registration::where('status', 'pending')->count();
        
        $currentSemester = Semester::where('is_current', true)->first();
        
        $recentCourses = Course::with('lecturer')
            ->withCount(['registrations' => function($query) {
                $query->where('status', 'approved');
            }])
            ->latest()
            ->take(5)
            ->get();
        
        $recentRegistrations = Registration::with(['student', 'course'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalStudents', 
            'totalLecturers', 
            'totalCourses',
            'pendingRegistrations',
            'currentSemester',
            'recentCourses',
            'recentRegistrations'
        ));
    }

    // --- 2. Course Management (RE-ADDED) ---
    public function coursesList()
    {
        $courses = Course::with(['lecturer', 'semester'])->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }

    public function createCourse()
    {
        $lecturers = User::where('role', 'lecturer')->get();
        $semesters = Semester::all();
        return view('admin.courses.create', compact('lecturers', 'semesters'));
    }

    public function storeCourse(Request $request)
    {
        $request->validate([
            'course_code' => 'required|unique:courses',
            'title' => 'required',
            'description' => 'nullable|string',
            'credit_hours' => 'nullable|integer|min:1',
            'max_students' => 'required|integer|min:1',
            'lecturer_id' => 'required|exists:users,id',
            'semester_id' => 'required|exists:semesters,id',
        ]);

        Course::create($request->all());

        return redirect()->route('admin.courses.index')->with('success', 'Course added successfully.');
    }

    public function editCourse(Course $course)
    {
        $lecturers = User::where('role', 'lecturer')->get();
        $semesters = Semester::all();
        return view('admin.courses.edit', compact('course', 'lecturers', 'semesters'));
    }

    public function updateCourse(Request $request, Course $course)
    {
        $request->validate([
            'course_code' => 'required|unique:courses,course_code,'.$course->id,
            'title' => 'required',
            'description' => 'nullable|string',
            'credit_hours' => 'nullable|integer|min:1',
            'max_students' => 'required|integer|min:1',
            'lecturer_id' => 'required|exists:users,id',
            'semester_id' => 'required|exists:semesters,id',
        ]);

        $course->update($request->all());

        return redirect()->route('admin.courses.index')->with('success', 'Course modified successfully.');
    }

    public function destroyCourse(Course $course)
    {
        $course->delete();
        return redirect()->back()->with('success', 'Course deleted successfully.');
    }

    // --- 3. Registration Management ---
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