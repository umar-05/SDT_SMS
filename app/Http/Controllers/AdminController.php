<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Registration;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // --- 1. View Dashboard ---
    public function dashboard()
    {
        $totalStudents = User::where('role', 'student')->count();
        $totalLecturers = User::where('role', 'lecturer')->count();
        $totalCourses = Course::count();
        
        return view('admin.dashboard', compact('totalStudents', 'totalLecturers', 'totalCourses'));
    }

    // --- 2. Course Management ---

    // [FIX] This function was missing, causing the white screen on the course list page
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
        // [FIX] Added max_students to validation to solve the "Default value" error
        $request->validate([
            'course_code' => 'required|unique:courses',
            'title' => 'required',
            'description' => 'nullable|string',
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
            'max_students' => 'required|integer|min:1',
        ]);

        $course->update($request->all());

        return redirect()->route('admin.courses.index')->with('success', 'Course modified successfully.');
    }

    public function destroyCourse(Course $course)
    {
        $course->delete();
        return redirect()->back()->with('success', 'Course deleted successfully.');
    }

    // --- 3. Amend Registration (Add/Remove students) ---
    public function manageRegistrations(Course $course)
    {
        $enrolledStudentIds = $course->registrations()->pluck('student_id');
        $availableStudents = User::where('role', 'student')
                                ->whereNotIn('id', $enrolledStudentIds)
                                ->get();
                                
        return view('admin.registrations.manage', compact('course', 'availableStudents'));
    }

    public function storeRegistration(Request $request, Course $course)
    {
        $request->validate(['student_id' => 'required|exists:users,id']);

        Registration::create([
            'course_id' => $course->id,
            'student_id' => $request->student_id
        ]);

        return redirect()->back()->with('success', 'Student added to course.');
    }

    public function destroyRegistration(Registration $registration)
    {
        $registration->delete();
        return redirect()->back()->with('success', 'Registration removed.');
    }
}