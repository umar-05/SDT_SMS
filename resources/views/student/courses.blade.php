@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Course Catalog</h2>
            <p class="text-sm text-gray-500">View all available courses and current enrollment status.</p>
        </div>
        <a href="{{ route('student.dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">Back to Dashboard</a>
    </div>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lecturer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrollment</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($courses as $course)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                        {{ $course->course_code }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        <div class="font-medium">{{ $course->title }}</div>
                        <div class="text-xs text-gray-500 truncate max-w-xs">{{ $course->description }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $course->lecturer->name ?? 'TBA' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $course->semester->name ?? '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="text-sm font-semibold {{ $course->registrations_count >= $course->max_students ? 'text-red-600' : 'text-gray-900' }}">
                                {{ $course->registrations_count }}
                            </span>
                            <span class="text-gray-400 text-xs mx-1">/</span>
                            <span class="text-sm text-gray-500">{{ $course->max_students }}</span>
                        </div>
                        @if($course->registrations_count >= $course->max_students)
                            <span class="text-xs text-red-500 font-medium">Full</span>
                        @else
                            <span class="text-xs text-green-500 font-medium">Open</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('student.courses.show', $course->id) }}" class="text-indigo-600 hover:text-indigo-900">Details</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">
                        No courses available in the system yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $courses->links() }}
        </div>
    </div>
</div>
@endsection