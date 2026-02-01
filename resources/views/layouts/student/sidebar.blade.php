<aside class="w-64 bg-white border-r border-gray-200 hidden md:block flex-shrink-0">
    <div class="h-full flex flex-col">
        <nav class="flex-1 mt-6 px-4 space-y-2 overflow-y-auto">
            
            <a href="{{ route('student.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('student.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} rounded-lg font-medium transition">
                <svg class="w-5 h-5 {{ request()->routeIs('student.dashboard') ? 'text-blue-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <span>Dashboard</span>
            </a>

            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Academic</p>
            </div>

            <a href="{{ route('student.courses.index') }}" class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('student.courses.index') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} rounded-lg transition">
                <svg class="w-5 h-5 {{ request()->routeIs('student.courses.index') ? 'text-blue-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span>View Courses</span>
            </a>

            <a href="{{ route('student.register') }}" class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('student.register') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} rounded-lg transition">
                <svg class="w-5 h-5 {{ request()->routeIs('student.register') ? 'text-blue-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Register New Course</span>
            </a>

            <a href="#" onclick="showSearchModal(); return false;" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-lg transition">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <span>Search Courses</span>
            </a>

            <a href="#" onclick="showModifyModal(); return false;" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-lg transition">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <span>Modify Registration</span>
            </a>
        </nav>
    </div>
</aside>