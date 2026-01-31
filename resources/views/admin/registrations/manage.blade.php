@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manage Registrations</h2>
            <p class="text-sm text-gray-500">Course: {{ $course->course_code }} - {{ $course->title }}</p>
        </div>
        <a href="{{ route('admin.courses.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Back to Courses</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Enrolled Students</h3>
            
            @if($course->registrations->isEmpty())
                <p class="text-gray-500 text-sm italic">No students enrolled.</p>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($course->registrations as $registration)
                    <li class="py-3 flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $registration->student->name }}</p>
                            <p class="text-xs text-gray-500">{{ $registration->student->email }}</p>
                        </div>
                        <form action="{{ route('admin.registrations.destroy', $registration->id) }}" method="POST" onsubmit="return confirm('Remove this student?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-600 hover:text-red-900 border border-red-200 rounded px-2 py-1 bg-red-50">Remove</button>
                        </form>
                    </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="bg-white shadow rounded-lg p-6 h-fit">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Add Student</h3>
            
            <form action="{{ route('admin.registrations.store', $course) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Student</label>
                    <select name="student_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">-- Choose Student --</option>
                        @foreach($availableStudents as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Add to Course</button>
            </form>
        </div>

    </div>
</div>
@endsection