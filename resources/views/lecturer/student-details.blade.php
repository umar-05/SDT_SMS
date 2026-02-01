@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Student Details</h2>
        <a href="{{ route('lecturer.course.show', $course) }}" class="text-sm text-gray-600 hover:text-gray-900 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Course
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                {{ $student->name }}
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Enrolled in {{ $course->course_code }}: {{ $course->title }}
            </p>
        </div>
        
        <div class="border-t border-gray-200">
            <dl>
                {{-- Academic Record Section (Immutable Data) --}}
                <div class="bg-blue-50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-blue-100">
                    <dt class="text-sm font-bold text-blue-600 uppercase tracking-wide">Matric Number</dt>
                    <dd class="mt-1 text-sm font-bold text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $student->profile->matric_number ?? 'N/A' }}
                    </dd>
                </div>
                <div class="bg-blue-50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-blue-100">
                    <dt class="text-sm font-bold text-blue-600 uppercase tracking-wide">Programme</dt>
                    <dd class="mt-1 text-sm font-bold text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $student->profile->programme ?? 'N/A' }}
                    </dd>
                </div>

                {{-- Basic Contact Information --}}
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $student->email }}</dd>
                </div>
                
                @if($student->profile)
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $student->profile->phone_number ?? 'N/A' }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Residential Address</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 leading-relaxed">
                            {{ $student->profile->address ?? 'N/A' }}
                        </dd>
                    </div>
                @else
                    <div class="bg-gray-50 px-4 py-5 sm:px-6">
                        <p class="text-sm text-gray-500 italic text-center">No additional profile information available.</p>
                    </div>
                @endif
            </dl>
        </div>
    </div>
</div>
@endsection