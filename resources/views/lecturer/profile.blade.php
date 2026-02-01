@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">My Profile</h2>
            <p class="mt-1 text-sm text-gray-600">Manage your lecturer profile information</p>
        </div>

        <div class="bg-white shadow-sm rounded-lg">
            <div class="p-6">
                <div class="max-w-2xl">
                    <header class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Lecturer Information</h3>
                        <p class="mt-1 text-sm text-gray-600">Update your contact details and office address.</p>
                    </header>

                    <form method="post" action="{{ route('lecturer.profile.update') }}" class="space-y-6">
                        @csrf
                        @method('patch')

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" 
                                   id="name" 
                                   value="{{ Auth::user()->name }}" 
                                   disabled
                                   class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm px-3 py-2">
                            <p class="mt-1 text-xs text-gray-500">Contact IT Staff to change your name</p>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" 
                                   id="email" 
                                   value="{{ Auth::user()->email }}" 
                                   disabled
                                   class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm px-3 py-2">
                            <p class="mt-1 text-xs text-gray-500">Contact IT Staff to change your email</p>
                        </div>

                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" 
                                   id="phone_number" 
                                   name="phone_number" 
                                   value="{{ old('phone_number', $profile->phone_number ?? '') }}" 
                                   required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2">
                            @error('phone_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Office Address</label>
                            <input type="text" 
                                   id="address" 
                                   name="address" 
                                   value="{{ old('address', $profile->address ?? '') }}" 
                                   required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2">
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                                Save Changes
                            </button>
                            
                            @if (session('status') === 'profile-updated')
                                <p class="text-sm text-green-600 font-medium">✓ Profile updated successfully!</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection