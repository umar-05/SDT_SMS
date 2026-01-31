<aside class="w-64 bg-white border-r border-gray-200 hidden md:block">
    <div class="h-full flex flex-col pt-4 pb-4 overflow-y-auto">
        <div class="px-4 mb-6">
            <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                Lecturer Portal
            </h2>
        </div>
        <nav class="flex-1 px-2 space-y-1">
            <a href="{{ route('lecturer.dashboard') }}" 
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('lecturer.dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                My Courses
            </a>
        </nav>
    </div>
</aside>