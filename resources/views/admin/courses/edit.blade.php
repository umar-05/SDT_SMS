@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Course: {{ $course->course_code }}</h2>
        <a href="{{ route('admin.courses.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
    </div>

    <div class="bg-white shadow-sm rounded-lg p-6">
        <form action="{{ route('admin.courses.update', $course) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Course Code</label>
                <input type="text" name="course_code" value="{{ $course->course_code }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Course Title</label>
                <input type="text" name="title" value="{{ $course->title }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $course->description }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Assign Lecturer</label>
                    <select name="lecturer_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach($lecturers as $lecturer)
                            <option value="{{ $lecturer->id }}" {{ $course->lecturer_id == $lecturer->id ? 'selected' : '' }}>{{ $lecturer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Semester</label>
                    <select name="semester_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach($semesters as $semester)
                            <option value="{{ $semester->id }}" {{ $course->semester_id == $semester->id ? 'selected' : '' }}>{{ $semester->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Update Course</button>
            </div>
        </form>
    </div>
</div>
@endsection