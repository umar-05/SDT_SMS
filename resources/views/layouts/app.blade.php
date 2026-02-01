<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <link rel="stylesheet" href="{{ asset('css/custom-animations.css') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Student Portal') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased h-full">
    <div class="min-h-screen bg-gray-50 flex flex-col">
        
        <header class="bg-white shadow-sm border-b border-gray-200 h-16 z-30 sticky top-0">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center justify-between">
                
                <div class="flex items-center gap-4">
                    <h1 class="text-xl font-bold text-gray-700">Student Portal</h1>
                </div>

                <div class="hidden md:flex items-center gap-2 text-gray-800 font-medium">
                    <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Academic Session : 202520261</span>
                </div>

                <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                    <button @click="open = ! open" class="flex items-center gap-3 focus:outline-none group">
                        <span class="text-sm text-gray-600 hidden md:block font-medium group-hover:text-gray-900 transition">{{ Auth::user()->name }}</span>
                        
                        <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-300 group-hover:border-blue-400 transition">
                            <svg class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        
                        <svg class="h-4 w-4 text-gray-400 group-hover:text-gray-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 py-1 focus:outline-none"
                         style="display: none;">
                        
                        @if(Auth::user()->role === 'student')
                            <a href="#" 
                            onclick="open = false; showProfileModal(); return false;" 
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Edit Profile
                            </a>
                            @elseif(Auth::user()->role === 'lecturer')
                                <a href="{{ route('lecturer.profile.edit') }}" 
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    My Profile
                                </a>
                            @endif

                        <div class="border-t border-gray-100"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); this.closest('form').submit();" 
                               class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                Sign Out
                            </a>
                        </form>
                    </div>
                </div>

            </div>
        </header>

        <div class="flex flex-1">
            @if(Auth::user()->role === 'student')
                @include('layouts.student.sidebar')
            @elseif(Auth::user()->role === 'lecturer')
                @include('layouts.lecturer.sidebar')
            @elseif(Auth::user()->role === 'it_staff')
                @include('layouts.it_staff.sidebar')
            @endif

            <main class="flex-1 p-8 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    @include('layouts.modals')

</body>
</html>