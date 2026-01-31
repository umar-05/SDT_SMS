<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the courses.
     */
    public function index()
    {
        $courses = Course::all();
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        return view('admin.courses.create');
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_code' => 'required|string|unique:courses,course_code|max:10',
            'title' => 'required|string|max:255',
            'credit_hours' => 'required|integer|min:1|max:6',
            'max_students' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        Course::create($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified course.
     */
    public function show(Course $course)
    {
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'course_code' => 'required|string|max:10|unique:courses,course_code,' . $course->id,
            'title' => 'required|string|max:255',
            'credit_hours' => 'required|integer|min:1|max:6',
            'max_students' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $course->update($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}