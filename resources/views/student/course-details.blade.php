@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col">
    <div class="flex flex-1">
        <main class="flex-1 p-8">
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
                                Course Catalog
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-1 text-gray-500">{{ $course->course_code }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-6">
                <div class="flex flex-col md:flex-row items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full">
                                {{ $course->course_code }}
                            </span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 text-sm font-semibold rounded-full">
                                {{ $course->semester->name ?? 'Semester TBA' }}
                            </span>
                            @if($isRegistered)
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-semibold rounded-full">
                                    Enrolled
                                </span>
                            @endif
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $course->title }}</h1>
                        
                        <p class="text-gray-600 leading-relaxed text-lg">
                            {{ $course->description ?? 'No detailed description available for this course.' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Instructor Information</h2>
                        
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center text-xl font-bold text-blue-600">
                                {{ substr($course->lecturer->name ?? '?', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-lg font-bold text-gray-900">{{ $course->lecturer->name ?? 'To Be Assigned' }}</p>
                                <p class="text-gray-600">{{ $course->lecturer->email ?? '' }}</p>
                                <p class="text-sm text-gray-500 mt-1">Lecturer</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Registration</h2>
                        
                        @php
                            $registrationsCount = $course->registrations()->where('status', 'approved')->count();
                            $spotsLeft = $course->max_students - $registrationsCount;
                            $isFull = $spotsLeft <= 0;
                        @endphp

                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Availability</span>
                                <span class="font-bold {{ $isFull ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $isFull ? 'Full' : 'Open' }}
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ min(100, ($registrationsCount / $course->max_students) * 100) }}%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2 text-right">
                                {{ $registrationsCount }} / {{ $course->max_students }} enrolled
                            </p>
                        </div>

                        <div class="space-y-3">
                            @if(!$isRegistered)
                                @if(!$isFull)
                                    <form action="{{ route('student.register.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                                        <button type="submit" class="block w-full px-4 py-3 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 font-bold transition shadow-md">
                                            Register Now
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="block w-full px-4 py-3 bg-gray-300 text-gray-500 text-center rounded-lg font-bold cursor-not-allowed">
                                        Course Full
                                    </button>
                                @endif
                            @else
                                <div class="block w-full px-4 py-3 bg-green-100 text-green-700 text-center rounded-lg font-bold border border-green-200">
                                    You are Enrolled
                                </div>
                            @endif
                            
                            <a href="{{ route('student.courses.index') }}" 
                                class="block w-full px-4 py-3 bg-white border border-gray-300 text-gray-700 text-center rounded-lg hover:bg-gray-50 font-medium transition">
                                Back to Catalog
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection