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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white shadow-sm border border-gray-200 rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                <h3 class="font-bold text-gray-800">Enrolled Students</h3>
                <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">
                    {{ $course->sections->flatMap->registrations->count() }} Total
                </span>
            </div>
            
            <div class="overflow-y-auto max-h-[600px]">
                <ul class="divide-y divide-gray-100">
                    @foreach($course->sections as $section)
                        @foreach($section->registrations as $registration)
                        <li class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-xs mr-3">
                                    {{ substr($registration->student->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $registration->student->name }} 
                                        <span class="text-xs text-blue-600">({{ $section->name }})</span>
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $registration->student->email }}</p>
                                </div>
                            </div>
                            <form action="{{ route('admin.registrations.destroy', $registration->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs text-red-600 hover:underline">Remove</button>
                            </form>
                        </li>
                        @endforeach
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="lg:col-span-1 bg-white shadow-sm border border-gray-200 rounded-lg p-6">
            <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Register Student</h3>
            <form action="{{ route('admin.registrations.store', $course) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Student</label>
                    <select name="student_id" class="block w-full rounded-md border-gray-300 text-sm" required>
                        @foreach($availableStudents as $student)
                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Assign Section</label>
                    <select name="section_id" class="block w-full rounded-md border-gray-300 text-sm" required>
                        @foreach($course->sections as $section)
                            @php 
                                $count = $section->registrations->where('status', 'approved')->count();
                                $remaining = $section->capacity - $count;
                            @endphp
                            <option value="{{ $section->id }}">
                                {{ $section->name }} 
                                @if($remaining > 0)
                                    ({{ $remaining }} spots left)
                                @else
                                    (FULL - Admin Override)
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="w-full bg-blue-700 text-white py-2 rounded-md text-sm font-medium hover:bg-blue-800">
                    Confirm Registration
                </button>
            </form>
        </div>
    </div>
</div>
@endsection