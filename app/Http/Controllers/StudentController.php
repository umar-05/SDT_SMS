<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Registration; // Don't forget this import!

class StudentController extends Controller
{
    public function index()
    {
        // Fetch registrations for the currently logged-in student
        // and include the 'course' details so we can show the title
        $registrations = Registration::with('course')
                            ->where('student_id', Auth::id())
                            ->get();

        return view('student.dashboard', compact('registrations'));
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
            // You can add a 'modification_reason' column if needed
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
        
        // Update basic info
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? $user->phone;
        
        // Update password if provided
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

    public function viewCourses()
    {
        $registrations = Registration::where('student_id', Auth::id())
            ->with('course')
            ->get();
        
        return view('student.courses', compact('registrations'));
    }

    public function courseDetails($id)
    {
        $course = Course::findOrFail($id);
        
        // Check if student is registered
        $isRegistered = Registration::where('student_id', Auth::id())
            ->where('course_id', $id)
            ->exists();
        
        return view('student.course-details', compact('course', 'isRegistered'));
    }

}