@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8 fade-in">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
        <p class="text-gray-600">Here's what's happening with your courses today.</p>
    </div>

    @php
        // Flatten all registrations for stats
        $allRegistrations = $groupedCourses->flatten(1);
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium mb-1">Enrolled Courses</p>
                    <h3 class="text-3xl font-bold">{{ $allRegistrations->where('status', 'approved')->count() }}</h3>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl shadow-lg p-6 text-white fade-in-delay-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium mb-1">Pending</p>
                    <h3 class="text-3xl font-bold">{{ $allRegistrations->where('status', 'pending')->count() }}</h3>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white fade-in-delay-2">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium mb-1">Total Credit Hours</p>
                    <h3 class="text-3xl font-bold">
                        {{ $allRegistrations->where('status', 'approved')->sum(function($reg) { 
                            return (int) ($reg->course->credit_hours ?? 0); 
                        }) }}
                    </h3>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <button onclick="showSearchModal()" 
                class="btn-primary bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl shadow-lg p-6 text-left transform hover:scale-105 transition-all fade-in">
            <div class="flex items-center justify-between mb-3">
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold mb-1">Search Courses</h3>
            <p class="text-sm text-blue-100">Find and register for courses</p>
        </button>

        <button onclick="showModifyModal()" 
                class="btn-primary bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white rounded-xl shadow-lg p-6 text-left transform hover:scale-105 transition-all fade-in-delay-1">
            <div class="flex items-center justify-between mb-3">
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold mb-1">Modify Registration</h3>
            <p class="text-sm text-purple-100">Update your course selections</p>
        </button>

        <a href="{{ route('student.courses.index') }}" 
           class="btn-primary bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-xl shadow-lg p-6 text-left transform hover:scale-105 transition-all fade-in-delay-2">
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
            <h3 class="text-lg font-bold mb-1">View All Courses</h3>
            <p class="text-sm text-green-100">Browse your enrolled courses</p>
        </a>
    </div>

    @if($groupedCourses->isEmpty())
        <div class="bg-white rounded-xl shadow-lg p-6 fade-in-delay-3">
            <div class="text-center py-16">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Enrolled Courses Yet</h3>
                <p class="text-gray-600 mb-6">Start by searching and registering for courses</p>
                <button onclick="showSearchModal()" 
                        class="btn-primary bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transform hover:scale-105 transition-all">
                    Search Courses Now
                </button>
            </div>
        </div>
    @else
        @foreach($groupedCourses as $semesterName => $registrations)
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8 fade-in-delay-3">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $semesterName }}</h2>
                    <span class="bg-blue-100 text-blue-800 text-sm font-medium px-4 py-2 rounded-full">
                        {{ $registrations->count() }} {{ $registrations->count() == 1 ? 'Course' : 'Courses' }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($registrations as $registration)
                        <div class="course-card bg-white border-2 border-gray-100 rounded-xl overflow-hidden hover:border-blue-300 transition-all">
                            <div class="bg-gradient-to-r from-blue-50 to-purple-50 p-5 border-b border-gray-100">
                                <div class="flex items-start justify-between mb-3">
                                    <span class="inline-block bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                                        {{ $registration->course->course_code }}
                                    </span>
                                    @if($registration->status === 'approved')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Approved
                                        </span>
                                    @elseif($registration->status === 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded-full flex items-center">
                                            <svg class="w-3 h-3 mr-1 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                            </svg>
                                            Pending
                                        </span>
                                    @endif
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 leading-tight">{{ $registration->course->title }}</h3>
                            </div>

                            <div class="p-5">
                                <div class="space-y-3 mb-4">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span class="font-medium">{{ $registration->course->lecturer->name ?? 'TBA' }}</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>{{ $registration->course->credit_hours }} Credit Hours</span>
                                    </div>
                                </div>

                                <a href="{{ route('student.course.details', $registration->course->id) }}" 
                                   class="btn-primary block w-full bg-blue-600 hover:bg-blue-700 text-white text-center font-medium py-2.5 px-4 rounded-lg transition-all transform hover:scale-105">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif

    @if($allRegistrations->where('status', 'pending')->isNotEmpty())
        <div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-lg p-6 fade-in-delay-3">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-medium text-yellow-800">Pending Registrations</h3>
                    <p class="mt-2 text-sm text-yellow-700">
                        You have {{ $allRegistrations->where('status', 'pending')->count() }} course registration(s) waiting for approval.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection