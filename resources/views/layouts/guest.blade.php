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
                        <x-application-logo class="w-12 h-12 fill-current text-blue-600" />
                    </div>
                    <span class="text-white text-2xl font-bold tracking-wide mt-2">Student Portal</span>
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