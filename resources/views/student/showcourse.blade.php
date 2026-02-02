@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    {{-- Success/Error Alerts --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Course Header Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="p-8">
            <div class="flex justify-between items-start">
                <div>
                    <span class="px-2 py-1 bg-blue-50 text-blue-600 text-xs font-bold rounded uppercase tracking-wider">
                        {{ $course->course_code }}
                    </span>
                    <h1 class="mt-2 text-3xl font-bold text-gray-900">{{ $course->title }}</h1>
                    <p class="mt-4 text-gray-600 leading-relaxed">{{ $course->description }}</p>
                </div>
            </div>
            
            <div class="mt-6 flex flex-wrap gap-6 text-sm text-gray-500 border-t pt-6">
                <div class="flex items-center">
                    <span class="font-semibold text-gray-700 mr-2">Lecturer:</span> {{ $course->lecturer->name }}
                </div>
                <div class="flex items-center">
                    <span class="font-semibold text-gray-700 mr-2">Semester:</span> {{ $course->semester->name }}
                </div>
            </div>
        </div>
    </div>

    {{-- Registration Section --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        @if($isRegistered)
            {{-- State: Already Enrolled --}}
            <div class="text-center py-4">
                <div class="inline-flex items-center px-4 py-2 bg-green-50 text-green-700 rounded-full font-bold mb-4">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Enrollment Confirmed
                </div>
                <p class="text-gray-500 mb-6">You are successfully registered for a section in this course.</p>
                <a href="{{ route('student.dashboard') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                    Return to Dashboard
                </a>
            </div>
        @else
            {{-- State: Available to Register --}}
            <h2 class="text-xl font-bold text-gray-900 mb-6">Available Sections</h2>
            
            <form action="{{ route('student.register.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    @foreach($course->sections as $section)
                        @php $isFull = ($section->capacity - $section->registrations->count()) <= 0; @endphp
                        <label class="relative flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition {{ $isFull ? 'opacity-50 cursor-not-allowed' : '' }}">
                            <input type="radio" name="section_id" value="{{ $section->id }}" class="h-4 w-4 text-blue-600 border-gray-300" {{ $isFull ? 'disabled' : 'required' }}>
                            <div class="ml-4 flex-1">
                                <div class="flex justify-between items-center">
                                    <span class="font-bold text-gray-900">{{ $section->name }}</span>
                                    <span class="text-xs font-medium {{ $isFull ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $section->capacity - $section->registrations->count() }} Seats Left
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500">{{ $section->schedule }} | {{ $section->room ?? 'Online' }}</p>
                            </div>
                        </label>
                    @endforeach
                </div>

                <button type="submit" class="mt-8 w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow-lg shadow-blue-200 transition">
                    Confirm Section & Enroll
                </button>
            </form>
        @endif
    </div>
</div>
@endsection