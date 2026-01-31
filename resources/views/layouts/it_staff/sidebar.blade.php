<aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col">
    <div class="p-6">
        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">
            IT Administration
        </h2>
        <nav class="space-y-1">
            <a href="{{ route('admin.dashboard') }}" 
               class="{{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-3 py-2 text-sm font-medium rounded-l-md transition-all duration-200">
                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.dashboard') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('admin.courses.index') }}" 
               class="{{ request()->routeIs('admin.courses.*') || request()->routeIs('admin.registrations.*') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-3 py-2 text-sm font-medium rounded-l-md transition-all duration-200">
                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.courses.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                Manage Courses
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