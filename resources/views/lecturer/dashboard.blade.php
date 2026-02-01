@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header with Animation -->
    <div class="mb-8 fade-in">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">My Assigned Courses</h1>
        <p class="text-gray-600">Academic Session 2025/2026</p>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Courses Card -->
        <div class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium mb-1">Total Courses</p>
                    <h3 class="text-4xl font-bold">{{ $courses->count() }}</h3>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Current Semester Card -->
        <div class="stat-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white fade-in-delay-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium mb-1">Current Semester</p>
                    <h3 class="text-4xl font-bold">{{ $courses->where('semester.is_current', true)->count() }}</h3>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Students Card -->
        <div class="stat-card bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white fade-in-delay-2">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium mb-1">Total Students</p>
                    <h3 class="text-4xl font-bold">{{ $courses->sum(function($course) { return $course->registrations->count(); }) }}</h3>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Courses Grid -->
    @if($courses->isEmpty())
        <div class="text-center py-16 bg-white rounded-xl shadow-sm fade-in-delay-3">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Courses Assigned</h3>
            <p class="text-gray-600">You don't have any courses assigned yet. Contact IT Staff for assistance.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($courses as $index => $course)
                <div class="course-card bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl fade-in-delay-{{ $index % 3 + 1 }}">
                    <!-- Course Header with Gradient -->
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <span class="inline-block bg-white bg-opacity-20 text-xs font-semibold px-3 py-1 rounded-full mb-2">
                                    {{ $course->course_code }}
                                </span>
                                <h3 class="text-xl font-bold leading-tight">{{ $course->title }}</h3>
                            </div>
                            <span class="badge bg-white bg-opacity-20 text-white text-xs px-3 py-1 rounded-full">
                                {{ $course->credit_hours }} CH
                            </span>
                        </div>
                        
                        <div class="flex items-center text-blue-100 text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $course->semester->name ?? 'N/A' }}
                        </div>
                    </div>

                    <!-- Course Body -->
                    <div class="p-6">
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {{ $course->description ?? 'No description available.' }}
                        </p>

                        <!-- Student Count -->
                        <div class="flex items-center justify-between mb-4 p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span class="font-medium">{{ $course->registrations->count() }} Students</span>
                            </div>
                            <span class="text-xs text-gray-500">Max: {{ $course->max_students }}</span>
                        </div>

                        <!-- Progress Bar -->
                        @php
                            $percentage = $course->max_students > 0 ? ($course->registrations->count() / $course->max_students) * 100 : 0;
                        @endphp
                        <div class="mb-4">
                            <div class="flex justify-between text-xs text-gray-600 mb-1">
                                <span>Enrollment</span>
                                <span>{{ number_format($percentage, 0) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full transition-all duration-500" 
                                     style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <a href="{{ route('lecturer.course.show', $course->id) }}" 
                           class="btn-primary block w-full bg-blue-600 hover:bg-blue-700 text-white text-center font-medium py-3 px-4 rounded-lg transition-all duration-300 transform hover:scale-105">
                            <span class="flex items-center justify-center">
                                View Student List
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Custom Styles -->
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection