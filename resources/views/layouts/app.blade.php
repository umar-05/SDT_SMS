<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
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

                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-600 hidden md:block">{{ Auth::user()->name }}</span>
                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center overflow-hidden border border-gray-300">
                        <svg class="h-12 w-12 text-gray-400 mt-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
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