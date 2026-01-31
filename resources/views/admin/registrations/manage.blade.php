@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-start">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                <a href="{{ route('admin.courses.index') }}" class="hover:text-blue-600">Courses</a>
                <span>/</span>
                <span>Manage Registrations</span>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">{{ $course->course_code }} - {{ $course->title }}</h2>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 bg-white shadow-sm border border-gray-200 rounded-lg flex flex-col">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                <h3 class="font-bold text-gray-800">Enrolled Students</h3>
                <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">{{ $course->registrations->count() }} Students</span>
            </div>
            
            <div class="flex-1 overflow-y-auto max-h-[600px]">
                @if($course->registrations->isEmpty())
                    <div class="p-8 text-center text-gray-500">
                        No students are currently enrolled in this course.
                    </div>
                @else
                    <ul class="divide-y divide-gray-100">
                        @foreach($course->registrations as $registration)
                        <li class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-xs mr-3">
                                    {{ substr($registration->student->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $registration->student->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $registration->student->email }}</p>
                                </div>
                            </div>
                            <form action="{{ route('admin.registrations.destroy', $registration->id) }}" method="POST" onsubmit="return confirm('Remove this student from the course?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-600 hover:text-red-900 font-medium hover:underline">Remove</button>
                            </form>
                        </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <div class="lg:col-span-1 h-fit bg-white shadow-sm border border-gray-200 rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="font-bold text-gray-800">Add Student</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.registrations.store', $course) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Student</label>
                        <select name="student_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required size="5">
                            @forelse($availableStudents as $student)
                                <option value="{{ $student->id }}" class="py-1">{{ $student->name }} ({{ $student->email }})</option>
                            @empty
                                <option disabled>All students enrolled</option>
                            @endforelse
                        </select>
                        <p class="mt-2 text-xs text-gray-500">Select a student to enroll them in this course.</p>
                    </div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50" {{ $availableStudents->isEmpty() ? 'disabled' : '' }}>
                        Register Student
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection