@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8 fade-in">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Admin Dashboard</h1>
                <p class="text-gray-600">System overview and management</p>
            </div>
            <div class="flex items-center bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-3 rounded-xl shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="font-semibold">Session: {{ $currentSemester->name ?? '2025/2026' }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <p class="text-blue-100 text-sm font-medium mb-1">Total Students</p>
            <h3 class="text-4xl font-bold">{{ $totalStudents ?? 0 }}</h3>
        </div>

        <div class="stat-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <p class="text-purple-100 text-sm font-medium mb-1">Total Lecturers</p>
            <h3 class="text-4xl font-bold">{{ $totalLecturers ?? 0 }}</h3>
        </div>

        <div class="stat-card bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <p class="text-green-100 text-sm font-medium mb-1">Total Courses</p>
            <h3 class="text-4xl font-bold">{{ $totalCourses ?? 0 }}</h3>
        </div>

        <div class="stat-card bg-gradient-to-br from-orange-500 to-red-500 rounded-xl shadow-lg p-6 text-white">
            <p class="text-orange-100 text-sm font-medium mb-1">Pending Requests</p>
            <h3 class="text-4xl font-bold">{{ $pendingRegistrations ?? 0 }}</h3>
        </div>
    </div>

    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('admin.courses.create') }}" 
            class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="bg-white bg-opacity-20 rounded-full p-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold mb-1">Add New Course</h3>
                <p class="text-sm text-blue-100">Create a new course offering</p>
            </a>

            <a href="{{ route('admin.courses.index') }}" 
            class="bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="bg-white bg-opacity-20 rounded-full p-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                    </div>
                    <div class="bg-red-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center">
                        {{ $pendingRegistrations ?? 0 }}
                    </div>
                </div>
                <h3 class="text-lg font-bold mb-1">Manage Courses</h3>
                <p class="text-sm text-purple-100">Edit courses and approve student enrollments</p>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900">Recent Courses</h2>
                <a href="{{ route('admin.courses.index') }}" class="text-blue-600 text-sm font-medium">View All →</a>
            </div>

            <div class="space-y-3">
                @forelse($recentCourses as $course)
                    <div class="border border-gray-100 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded">{{ $course->course_code }}</span>
                                <h4 class="font-semibold text-gray-900 text-sm mt-1">{{ $course->title }}</h4>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-900">{{ $course->registrations_count ?? 0 }}/{{ $course->max_students }}</p>
                                <p class="text-xs text-gray-500">Students</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500">No courses yet</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Pending Registrations</h2>
            <div class="space-y-3">
                @forelse($recentRegistrations as $registration)
                    <div class="border border-gray-100 rounded-lg p-4">
                        <div class="mb-3">
                            <h4 class="font-semibold text-gray-900 text-sm">{{ $registration->student->name }}</h4>
                            <p class="text-xs text-gray-500">{{ $registration->course->course_code }} - {{ $registration->course->title }}</p>
                        </div>
                        <div class="flex gap-2">
                            <form action="{{ route('admin.registrations.status', $registration) }}" method="POST" class="flex-1">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="w-full bg-green-600 text-white text-xs py-2 rounded">Approve</button>
                            </form>
                            <form action="{{ route('admin.registrations.status', $registration) }}" method="POST" class="flex-1">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="w-full bg-red-600 text-white text-xs py-2 rounded">Reject</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500">All caught up!</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection