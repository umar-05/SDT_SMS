<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-800">Student Management System</h2>
        <p class="text-sm text-gray-500 mt-1">Please sign in to access your dashboard.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full p-3 border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="student@university.edu" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full p-3 border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg"
                            type="password"
                            name="password"
                            required autocomplete="current-password" 
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:text-blue-800 font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3 bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-lg font-bold text-white shadow-md transition-all">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
        
        <div class="mt-6 text-center text-sm text-gray-500">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-bold">Register here</a>
        </div>
    </form>
</x-guest-layout>