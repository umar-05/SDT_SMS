@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">My Assigned Courses</h2>
        <span class="text-sm text-gray-500">Academic Session 2025/2026</span>
    </div>

    @if($courses->isEmpty())
        <div class="bg-white p-12 rounded-lg border border-gray-200 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No courses assigned</h3>
            <p class="mt-1 text-sm text-gray-500">You haven't been assigned any courses for this semester yet.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($courses as $course)
            <div class="group bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md hover:border-blue-300 transition-all duration-200 flex flex-col h-full">
                <div class="p-6 flex-1">
                    <div class="flex justify-between items-start mb-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                            {{ $course->course_code }}
                        </span>
                        <span class="text-xs text-gray-400">
                            {{ $course->semester ? $course->semester->name : 'N/A' }}
                        </span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-700 transition-colors">
                        {{ $course->title }}
                    </h3>
                    <p class="mt-2 text-sm text-gray-500 line-clamp-2">
                        {{ $course->description ?? 'No description available for this course.' }}
                    </p>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 rounded-b-lg">
                    <a href="{{ route('lecturer.course.show', $course) }}" class="flex items-center justify-center w-full text-sm font-medium text-blue-700 hover:text-blue-900 transition-colors">
                        View Student List &rarr;
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection