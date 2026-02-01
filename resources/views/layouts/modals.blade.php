<div id="searchModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal('searchModal')"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Search Courses</h3>
                <div class="mt-4">
                    <input type="text" id="courseSearchInput" placeholder="Type course code or title..." class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <div id="searchResults" class="mt-4 space-y-2 max-h-60 overflow-y-auto"></div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal('searchModal')">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="modifyModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal('modifyModal')"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Modify Registration</h3>
                        <p class="text-sm text-gray-500 mb-4">Manage your current enrollments. You can drop pending or approved courses here.</p>
                        
                        <div class="mt-4 border-t border-gray-100 pt-4 max-h-60 overflow-y-auto">
                            @if(Auth::user()->role === 'student' && isset($registrations) && $registrations->isNotEmpty())
                                <ul class="divide-y divide-gray-200">
                                    @foreach($registrations as $reg)
                                        <li class="py-3 flex justify-between items-center">
                                            <div>
                                                <p class="text-sm font-bold text-gray-900">{{ $reg->course->course_code }}</p>
                                                <p class="text-xs text-gray-500">{{ $reg->course->title }}</p>
                                            </div>
                                            <div class="flex items-center gap-3">
                                                <span class="px-2 py-1 text-xs rounded-full {{ $reg->status == 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($reg->status) }}
                                                </span>
                                                <form action="{{ route('student.register.destroy', $reg->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to drop this course?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-bold hover:underline">
                                                        Drop
                                                    </button>
                                                </form>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center py-4 bg-gray-50 rounded-lg">
                                    <p class="text-gray-500 text-sm">No active course registrations found.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal('modifyModal')">Done</button>
            </div>
        </div>
    </div>
</div>

<div id="profileModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal('profileModal')"></div>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <form action="{{ route('student.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Profile</h3>
                            <p class="text-sm text-gray-500 mb-4">Update your personal information.</p>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Full Name</label>
                                    <input type="text" name="name" value="{{ auth()->user()->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email Address</label>
                                    <input type="email" name="email" value="{{ auth()->user()->email }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input type="text" name="phone" value="{{ auth()->user()->phone ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Optional">
                                </div>

                                <hr class="my-4 border-gray-200">
                                <p class="text-xs text-gray-500 uppercase font-bold">Change Password (Optional)</p>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Current Password</label>
                                    <input type="password" name="current_password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Only if changing password">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">New Password</label>
                                    <input type="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Save Changes</button>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal('profileModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // 1. Function to SHOW Modals
    function showModifyModal() {
        document.getElementById('modifyModal').classList.remove('hidden');
    }
    
    function showSearchModal() {
        document.getElementById('searchModal').classList.remove('hidden');
    }

    // [FIX] Added this function so the "Edit Profile" button works
    function showProfileModal() {
        document.getElementById('profileModal').classList.remove('hidden');
    }

    // 2. Function to CLOSE Modals
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    // 3. Search Logic
    const searchInput = document.getElementById('courseSearchInput');
    if(searchInput){
        searchInput.addEventListener('keyup', function() {
            let query = this.value;
            if (query.length > 1) {
                fetch(`{{ route('student.courses.search') }}?q=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        let html = '';
                        if(data.length > 0){
                            data.forEach(course => {
                                html += `
                                    <div class="p-3 bg-gray-50 rounded flex justify-between items-center hover:bg-gray-100 transition">
                                        <div>
                                            <div class="font-bold text-sm text-gray-900">${course.course_code}</div>
                                            <div class="text-xs text-gray-600">${course.title}</div>
                                        </div>
                                        <a href="/student/courses/${course.id}" class="text-blue-600 text-xs font-medium hover:underline">View</a>
                                    </div>
                                `;
                            });
                        } else {
                            html = '<p class="text-sm text-gray-500 text-center py-2">No courses found.</p>';
                        }
                        document.getElementById('searchResults').innerHTML = html;
                    });
            } else {
                document.getElementById('searchResults').innerHTML = '';
            }
        });
    }
</script>