@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Admin Header -->
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

    <!-- System Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Students -->
        <div class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white fade-in">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-blue-100 text-sm font-medium mb-1">Total Students</p>
            <h3 class="text-4xl font-bold">{{ $totalStudents ?? 0 }}</h3>
            <div class="mt-3 flex items-center text-blue-100 text-sm">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/>
                </svg>
                Active users
            </div>
        </div>

        <!-- Total Lecturers -->
        <div class="stat-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white fade-in-delay-1">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-purple-100 text-sm font-medium mb-1">Total Lecturers</p>
            <h3 class="text-4xl font-bold">{{ $totalLecturers ?? 0 }}</h3>
            <div class="mt-3 flex items-center text-purple-100 text-sm">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                </svg>
                Teaching staff
            </div>
        </div>

        <!-- Total Courses -->
        <div class="stat-card bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white fade-in-delay-2">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
            <p class="text-green-100 text-sm font-medium mb-1">Total Courses</p>
            <h3 class="text-4xl font-bold">{{ $totalCourses ?? 0 }}</h3>
            <div class="mt-3 flex items-center text-green-100 text-sm">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                </svg>
                Available
            </div>
        </div>

        <!-- Pending Registrations -->
        <div class="stat-card bg-gradient-to-br from-orange-500 to-red-500 rounded-xl shadow-lg p-6 text-white fade-in-delay-3">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-orange-100 text-sm font-medium mb-1">Pending Requests</p>
            <h3 class="text-4xl font-bold">{{ $pendingRegistrations ?? 0 }}</h3>
            <div class="mt-3 flex items-center text-orange-100 text-sm">
                <svg class="w-4 h-4 mr-1 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                Needs action
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-4 fade-in">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('admin.courses.create') }}" 
               class="btn-primary bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-all fade-in">
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
               class="btn-primary bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-all fade-in-delay-1">
                <div class="flex items-center justify-between mb-3">
                    <div class="bg-white bg-opacity-20 rounded-full p-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                    </div>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold mb-1">Manage Courses</h3>
                <p class="text-sm text-purple-100">View and edit all courses</p>
            </a>

            <button onclick="showRegistrationManagement()" 
                    class="btn-primary bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-xl shadow-lg p-6 text-left transform hover:scale-105 transition-all fade-in-delay-2">
                <div class="flex items-center justify-between mb-3">
                    <div class="bg-white bg-opacity-20 rounded-full p-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div class="bg-red-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center">
                        {{ $pendingRegistrations ?? 0 }}
                    </div>
                </div>
                <h3 class="text-lg font-bold mb-1">Manage Registrations</h3>
                <p class="text-sm text-green-100">Approve or reject requests</p>
            </button>
        </div>
    </div>

    <!-- Recent Activity & Courses Table -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Courses -->
        <div class="bg-white rounded-xl shadow-lg p-6 fade-in-delay-1">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900">Recent Courses</h2>
                <a href="{{ route('admin.courses.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    View All →
                </a>
            </div>

            @if(isset($recentCourses) && $recentCourses->isNotEmpty())
                <div class="space-y-3">
                    @foreach($recentCourses->take(5) as $course)
                        <div class="table-row border border-gray-100 rounded-lg p-4 hover:border-blue-300">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-1">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded">
                                            {{ $course->course_code }}
                                        </span>
                                        <span class="ml-2 text-xs text-gray-500">
                                            {{ $course->credit_hours }} CH
                                        </span>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 text-sm">{{ $course->title }}</h4>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $course->lecturer->name ?? 'No lecturer assigned' }}
                                    </p>
                                </div>
                                <div class="text-right ml-4">
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ $course->registrations_count ?? 0 }}/{{ $course->max_students }}
                                    </p>
                                    <p class="text-xs text-gray-500">Students</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <p>No courses yet</p>
                </div>
            @endif
        </div>

        <!-- Pending Registrations -->
        <div class="bg-white rounded-xl shadow-lg p-6 fade-in-delay-2">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900">Pending Registrations</h2>
                @if(isset($recentRegistrations) && $recentRegistrations->isNotEmpty())
                    <span class="bg-orange-100 text-orange-800 text-xs font-bold px-3 py-1 rounded-full">
                        {{ $recentRegistrations->count() }} Pending
                    </span>
                @endif
            </div>

            @if(isset($recentRegistrations) && $recentRegistrations->isNotEmpty())
                <div class="space-y-3">
                    @foreach($recentRegistrations->take(5) as $registration)
                        <div class="table-row border border-gray-100 rounded-lg p-4 hover:border-orange-300">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900 text-sm">
                                        {{ $registration->student->name }}
                                    </h4>
                                    <p class="text-xs text-gray-500">
                                        {{ $registration->course->course_code }} - {{ $registration->course->title }}
                                    </p>
                                </div>
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded-full">
                                    Pending
                                </span>
                            </div>
                            <div class="flex gap-2 mt-3">
                                <button class="flex-1 bg-green-600 hover:bg-green-700 text-white text-xs font-medium py-2 px-3 rounded transition-all transform hover:scale-105">
                                    Approve
                                </button>
                                <button class="flex-1 bg-red-600 hover:bg-red-700 text-white text-xs font-medium py-2 px-3 rounded transition-all transform hover:scale-105">
                                    Reject
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p>All caught up!</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function showRegistrationManagement() {
    alert('Registration management feature - link to registration page');
}
</script>
@endsection