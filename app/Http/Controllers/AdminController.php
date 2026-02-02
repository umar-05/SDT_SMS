<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Section;
use App\Models\Registration;
use Illuminate\Http\Request;

class AdminController extends Controller
{
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
            ->latest()->take(5)->get();
        
        $recentRegistrations = Registration::with(['student', 'section.course'])
            ->where('status', 'pending')
            ->latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'totalStudents', 'totalLecturers', 'totalCourses',
            'pendingRegistrations', 'currentSemester', 'recentCourses', 'recentRegistrations'
        ));
    }

    // --- Course Management ---

    // [FIX] Added missing coursesList method to resolve "undefined method" error
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
        $validated = $request->validate([
            'course_code'  => 'required|unique:courses',
            'title'        => 'required',
            'description'  => 'nullable|string',
            'max_students' => 'required|integer|min:1',
            'lecturer_id'  => 'required|exists:users,id',
            'semester_id'  => 'required|exists:semesters,id',
        ]);

        \DB::transaction(function () use ($validated) {
            $course = Course::create($validated);

            $course->sections()->create([
                'name'     => 'Section 01',
                'capacity' => $validated['max_students'],
                'schedule' => 'TBA',
                'room'     => 'TBA'
            ]);
        });

        return redirect()->route('admin.courses.index')->with('success', 'Course and Section 01 created successfully!');
    }

    public function editCourse(Course $course)
    {
        $lecturers = User::where('role', 'lecturer')->get();
        $semesters = Semester::all();
        return view('admin.courses.edit', compact('course', 'lecturers', 'semesters'));
    }

    // [FIX] Added missing updateCourse method
    public function updateCourse(Request $request, Course $course)
    {
        $validated = $request->validate([
            'course_code'  => 'required|unique:courses,course_code,'.$course->id,
            'title'        => 'required',
            'max_students' => 'required|integer|min:1',
            'lecturer_id'  => 'required|exists:users,id',
            'semester_id'  => 'required|exists:semesters,id',
        ]);

        $course->update($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Course modified successfully.');
    }

    // [FIX] Added missing destroyCourse method
    public function destroyCourse(Course $course)
    {
        $course->delete();
        return redirect()->back()->with('success', 'Course deleted successfully.');
    }

    // --- Registration Management ---

    public function manageRegistrations(Course $course)
    {
        $course->load(['sections.registrations.student.profile']);

        $enrolledStudentIds = Registration::whereHas('section', function($q) use ($course) {
                $q->where('course_id', $course->id);
            })->pluck('student_id');

        $availableStudents = User::where('role', 'student')
                                    ->whereNotIn('id', $enrolledStudentIds)
                                    ->get();
                                    
        return view('admin.registrations.manage', compact('course', 'availableStudents'));
    }

    public function storeRegistration(Request $request, Course $course)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'section_id' => 'required|exists:sections,id'
        ]);

        $section = Section::withCount(['registrations' => function($q) {
            $q->where('status', 'approved');
        }])->findOrFail($request->section_id);
        
        // Admin Override: If full, still allow registration but mark as approved 
        // (or pending if you prefer they manually approve waitlists later).
        $isFull = $section->registrations_count >= $section->capacity;

        Registration::create([
            'section_id' => $section->id,
            'student_id' => $request->student_id,
            'status'     => 'approved' // Admin manual entry is usually auto-approved
        ]);

        $msg = $isFull ? "Admin Override: Student added to full section." : "Student registered successfully.";

        return redirect()->back()->with('success', $msg);
    }

    public function destroyRegistration(Registration $registration)
    {
        $registration->delete();
        return redirect()->back()->with('success', 'Registration removed.');
    }

    public function updateRegistrationStatus(Request $request, Registration $registration)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending'
        ]);

        // Check capacity if an admin is moving someone from 'pending' to 'approved'
        if ($request->status === 'approved') {
            $section = $registration->section;
            $current = $section->registrations()->where('status', 'approved')->count();
            
            if ($current >= $section->capacity) {
                // We allow the admin to override if they want, or you can block them:
                // return redirect()->back()->with('error', 'Section is full. Manual override required.');
            }
        }

        $registration->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Registration status updated to ' . ucfirst($request->status));
    }

}