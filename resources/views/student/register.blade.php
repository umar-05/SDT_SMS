@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Course Registration</h2>
            <p class="text-sm text-gray-500">Browse and enroll in available courses.</p>
        </div>
        
        <form method="GET" action="{{ route('student.register') }}" class="w-full md:w-1/3">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                       placeholder="Search by code or title...">
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4">
            <div class="flex">
                <div class="ml-3">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4">
            <div class="flex">
                <div class="ml-3">
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($courses as $course)
            @php
                // Calculate logic for display
                $enrolledCount = $course->registrations()->where('status', 'approved')->count();
                $isFull = $enrolledCount >= $course->max_students;
                $available = $course->max_students - $enrolledCount;
                
                // Check if user is already enrolled (Optimization: could be passed from controller, but this works for small lists)
                $isRegistered = $course->registrations()->where('student_id', auth()->id())->exists();
            @endphp

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 flex flex-col h-full hover:border-blue-300 transition-colors">
                <div class="p-6 flex-1">
                    <div class="flex justify-between items-start mb-4">
                        <span class="px-2 py-1 bg-gray-100 text-xs font-semibold text-gray-600 rounded">
                            {{ $course->course_code }}
                        </span>
                        <span class="text-xs text-gray-500">{{ $course->semester->name }}</span>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $course->title }}</h3>
                    <p class="text-sm text-gray-500 line-clamp-2 mb-4">{{ $course->description ?? 'No description.' }}</p>
                    
                    <div class="flex items-center text-sm text-gray-600 mb-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        {{ $course->lecturer->name ?? 'Unassigned' }}
                    </div>
                    
                    <div class="flex items-center text-sm {{ $isFull ? 'text-red-600' : 'text-green-600' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        {{ $available }} spots left
                    </div>
                </div>

                <div class="p-4 bg-gray-50 border-t border-gray-100">
                    @if($isRegistered)
                        <button disabled class="w-full py-2 px-4 bg-gray-300 text-gray-500 rounded cursor-not-allowed text-sm font-medium">
                            Already Registered
                        </button>
                    @else
                        <form action="{{ route('student.register.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <button type="submit" class="w-full py-2 px-4 rounded text-sm font-medium text-white transition-colors {{ $isFull ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-blue-600 hover:bg-blue-700' }}">
                                {{ $isFull ? 'Join Waitlist' : 'Enroll Now' }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500">No courses found matching your search.</p>
                <a href="{{ route('student.register') }}" class="text-blue-600 hover:underline mt-2 inline-block">Clear Search</a>
            </div>
        @endforelse
    </div>
</div>
@endsection