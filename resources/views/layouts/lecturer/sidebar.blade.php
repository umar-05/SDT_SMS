<aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col">
    <div class="p-6">
        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">
            Lecturer Menu
        </h2>
        <nav class="space-y-1">
            <a href="{{ route('lecturer.dashboard') }}" 
               class="{{ request()->routeIs('lecturer.dashboard') || request()->routeIs('lecturer.course.*') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-3 py-2 text-sm font-medium rounded-l-md transition-all duration-200">
                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('lecturer.dashboard') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                My Courses
            </a>

            <a href="{{ route('profile.edit') }}" 
               class="{{ request()->routeIs('profile.edit') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-3 py-2 text-sm font-medium rounded-l-md transition-all duration-200">
                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('profile.edit') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                My Profile
            </a>
        </nav>
    </div>

    <div class="mt-auto p-6 border-t border-gray-100">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center text-sm font-medium text-red-600 hover:text-red-800 transition-colors w-full">
                <svg class="mr-3 h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Sign Out
            </button>
        </form>
    </div>
</aside>