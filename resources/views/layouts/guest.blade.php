<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Student Portal') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-blue-500 to-indigo-700">
            
            <div class="mb-6">
                <a href="/" class="flex flex-col items-center gap-2">
                    <div class="bg-white p-3 rounded-full shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-blue-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.174L10.72 14.12a1.25 1.25 0 001.28 0l6.46-3.946M3.104 6.703a.75.75 0 011.024-.149l7.15 4.382a.75.75 0 00.744 0l7.15-4.382a.75.75 0 11.798 1.27l-7.15 4.382a2.25 2.25 0 01-2.232 0l-7.15-4.382a.75.75 0 01-.149-1.024z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.5h18v5.25a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18.75V13.5z" />
                        </svg>
                    </div>
                    <span class="text-white t   ext-2xl font-bold tracking-wide mt-2">Student Portal</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-10 bg-white shadow-2xl overflow-hidden sm:rounded-xl border border-gray-100">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-blue-100 text-sm opacity-80">
                &copy; {{ date('Y') }} Student Management System
            </div>
        </div>
    </body>
</html>