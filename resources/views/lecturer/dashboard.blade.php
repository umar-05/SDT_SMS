@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-800">My Assigned Courses</h2>

    @if($courses->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
            You have not been assigned any courses yet.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($courses as $course)
            <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100 hover:shadow-md transition">
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $course->course_code }}
                        </span>
                        <span class="text-xs text-gray-500">
                            {{ $course->semester ? $course->semester->name : 'N/A' }}
                        </span>
                    </div>
                    <div class="mt-4 mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $course->title }}</h3>
                        <p class="mt-1 text-sm text-gray-500 truncate">
                            {{ $course->description ?? 'No description provided.' }}
                        </p>
                    </div>
                    <a href="{{ route('lecturer.course.show', $course) }}" class="block w-full text-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        View Student List
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection