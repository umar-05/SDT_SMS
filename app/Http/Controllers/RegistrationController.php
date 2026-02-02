<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Course;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function create(Request $request)
    {
        // We eager load sections and their registration counts to calculate "spots left"
        $query = Course::with(['lecturer', 'semester', 'sections.registrations']);

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('course_code', 'like', '%' . $searchTerm . '%');
            });
        }

        $courses = $query->get();
        return view('student.register', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
        ]);

        $section = Section::with('course')->findOrFail($request->section_id);
        $studentId = Auth::id();

        // 1. Check if already registered for any section of THIS course
        $existing = Registration::where('student_id', $studentId)
            ->whereHas('section', function($q) use ($section) {
                $q->where('course_id', $section->course_id);
            })->exists();

        if ($existing) {
            return redirect()->back()->with('error', 'You are already registered for this course.');
        }

        // 2. Capacity Check for the specific section
        $currentApproved = Registration::where('section_id', $section->id)
                                    ->where('status', 'approved')
                                    ->count();

        if ($currentApproved < $section->capacity) {
            $status = 'approved';
            $msg = 'Registration successful! Enrolled in ' . $section->name;
        } else {
            $status = 'pending';
            $msg = 'Section is full. Your registration is pending.';
        }

        Registration::create([
            'student_id' => $studentId,
            'section_id' => $section->id, // Save section_id, not course_id
            'status' => $status,
        ]);

        return redirect()->route('student.register')->with('success', $msg);
    }
}