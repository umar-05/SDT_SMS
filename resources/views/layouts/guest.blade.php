<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Student Portal') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    <body class="antialiased text-gray-900 bg-white">
        <div class="min-h-screen flex">
            
            <div class="hidden lg:flex w-1/2 bg-slate-900 relative justify-center items-center overflow-hidden">
                <div class="absolute inset-0 opacity-20">
                    <svg class="h-full w-full text-slate-700" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <path d="M0 100 C 20 0 50 0 100 100 Z"></path>
                    </svg>
                </div>
                
                <div class="relative z-10 px-12 text-center">
                    <h2 class="text-4xl font-bold text-white tracking-tight mb-4">Academic Excellence</h2>
                    <p class="text-slate-300 text-lg">Welcome to the Student & Staff Management Portal. <br>Secure, reliable, and efficient.</p>
                </div>
            </div>

            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center px-6 py-12 lg:px-24 bg-gray-50">
                <div class="w-full max-w-md space-y-8">
                    <div class="text-center lg:text-left">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg bg-blue-700 text-white mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">Sign in to account</h2>
                        <p class="mt-2 text-sm text-gray-600">Please enter your credentials to access the portal.</p>
                    </div>

                    <div class="bg-white py-8 px-4 shadow-xl shadow-slate-200/50 sm:rounded-lg sm:px-10 border border-gray-100">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>