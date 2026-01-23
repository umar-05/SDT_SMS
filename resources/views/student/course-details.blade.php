@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col">


    <div class="flex flex-1">

        <main class="flex-1 p-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('student.dashboard') }}" class="text-gray-600 hover:text-gray-900">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <a href="{{ route('student.courses.index') }}" class="ml-1 text-gray-600 hover:text-gray-900">
                                My Courses
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-1 text-gray-500">Course Details</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Course Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full">
                                {{ $course->course_code }}
                            </span>
                            @if($isRegistered)
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-semibold rounded-full">
                                    Enrolled
                                </span>
                            @endif
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $course->title }}</h1>
                        
                        @if($course->description)
                            <p class="text-gray-600 leading-relaxed">{{ $course->description }}</p>
                        @endif
                    </div>
                    
                    @if(!$isRegistered)
                        <a href="{{ route('student.register') }}?course={{ $course->id }}" 
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium whitespace-nowrap">
                            Register for this Course
                        </a>
                    @endif
                </div>
            </div>

            <!-- Course Details Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Course Information -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Course Information</h2>
                        
                        <div class="space-y-4">
                            @if($course->prerequisites)
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Prerequisites</h3>
                                <p class="text-gray-600">{{ $course->prerequisites }}</p>
                            </div>
                            @endif

                            @if($course->learning_outcomes)
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Learning Outcomes</h3>
                                <p class="text-gray-600">{{ $course->learning_outcomes }}</p>
                            </div>
                            @endif

                            @if($course->assessment_methods)
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Assessment Methods</h3>
                                <p class="text-gray-600">{{ $course->assessment_methods }}</p>
                            </div>
                            @endif

                            @if($course->textbooks)
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Recommended Textbooks</h3>
                                <p class="text-gray-600">{{ $course->textbooks }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Course Schedule (if available) -->
                    @if($course->schedule)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Schedule</h2>
                        <div class="space-y-3">
                            @foreach(json_decode($course->schedule, true) ?? [] as $schedule)
                            <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $schedule['day'] ?? 'TBA' }}</p>
                                    <p class="text-sm text-gray-600">{{ $schedule['time'] ?? 'Time TBA' }} - {{ $schedule['location'] ?? 'Location TBA' }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Course Stats -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Course Details</h2>
                        
                        <div class="space-y-4">
                            @if($course->credits)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Credits</span>
                                <span class="font-semibold text-gray-900">{{ $course->credits }}</span>
                            </div>
                            @endif

                            @if($course->level)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Level</span>
                                <span class="font-semibold text-gray-900">{{ $course->level }}</span>
                            </div>
                            @endif

                            @if($course->department)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Department</span>
                                <span class="font-semibold text-gray-900">{{ $course->department }}</span>
                            </div>
                            @endif

                            @if($course->semester)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Semester</span>
                                <span class="font-semibold text-gray-900">{{ $course->semester }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Instructor Info -->
                    @if($course->instructor_name)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Instructor</h2>
                        
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $course->instructor_name }}</p>
                                @if($course->instructor_email)
                                <a href="mailto:{{ $course->instructor_email }}" class="text-sm text-blue-600 hover:underline">
                                    {{ $course->instructor_email }}
                                </a>
                                @endif
                            </div>
                        </div>

                        @if($course->instructor_office)
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <p class="text-sm text-gray-600">Office: {{ $course->instructor_office }}</p>
                        </div>
                        @endif

                        @if($course->instructor_hours)
                        <div class="mt-2">
                            <p class="text-sm text-gray-600">Office Hours: {{ $course->instructor_hours }}</p>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                        
                        <div class="space-y-2">
                            @if(!$isRegistered)
                                <a href="{{ route('student.register') }}?course={{ $course->id }}" 
                                    class="block w-full px-4 py-2 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 font-medium">
                                    Register for Course
                                </a>
                            @endif
                            
                            <a href="{{ route('student.courses.index') }}" 
                                class="block w-full px-4 py-2 bg-gray-100 text-gray-700 text-center rounded-lg hover:bg-gray-200 font-medium">
                                Back to My Courses
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection