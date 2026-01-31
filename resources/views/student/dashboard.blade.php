@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">My Learning Dashboard</h2>
        <a href="{{ route('student.register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700 transition">
            Register for New Courses
        </a>
    </div>

    @if($groupedCourses->isEmpty())
        <div class="bg-white p-10 rounded-lg shadow-sm text-center border border-gray-100">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No active enrollments</h3>
            <p class="mt-1 text-sm text-gray-500">You haven't registered for any courses yet.</p>
        </div>
    @else
        @foreach($groupedCourses as $semesterName => $registrations)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800">{{ $semesterName }}</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($registrations as $reg)
                        <div class="border rounded-lg p-5 hover:shadow-md transition-shadow relative bg-white">
                            <div class="flex justify-between items-start mb-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $reg->course->course_code }}
                                </span>
                                <span class="text-xs text-green-600 font-semibold bg-green-50 px-2 py-1 rounded">
                                    {{ ucfirst($reg->status) }}
                                </span>
                            </div>
                            <h4 class="text-md font-bold text-gray-900 mb-1">{{ $reg->course->title }}</h4>
                            <p class="text-sm text-gray-500 mb-4">
                                {{ $reg->course->lecturer->name ?? 'TBA' }}
                            </p>
                            
                            <div class="flex items-center justify-between mt-4 border-t pt-4">
                                <span class="text-xs text-gray-400">Grade: <strong class="text-gray-800">{{ $reg->grade ?? 'N/A' }}</strong></span>
                                <a href="{{ route('student.courses.show', $reg->course->id) }}" class="text-xs text-blue-600 hover:text-blue-900 font-medium">View Details</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection