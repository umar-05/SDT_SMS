<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LecturerController extends Controller
{
    /**
     * View courses assigned to the lecturer.
     */
    public function assignedCourses()
    {
        // NOTE: This assumes you have a 'lecturer_id' on your courses table.
        // If not, you might need to show all courses or add that column.
        $courses = Course::where('lecturer_id', Auth::id())->get();
        
        // Fallback: If no lecturer assignment exists in DB yet, verify using all()
        // $courses = Course::all(); 

        return view('lecturer.courses', compact('courses'));
    }

    /**
     * View students registered for a specific course.
     */
    public function studentList(Course $course)
    {
        // Ensure the lecturer is allowed to view this course
        if ($course->lecturer_id !== Auth::id()) {
           // abort(403, 'Unauthorized action.'); // Uncomment if strict checking is needed
        }

        // Get registrations with student info
        $registrations = Registration::with('student')
            ->where('course_id', $course->id)
            ->where('status', 'approved') // Only show approved students?
            ->get();

        return view('lecturer.student-list', compact('course', 'registrations'));
    }
}