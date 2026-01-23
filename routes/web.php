<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// IT STAFF ROUTES
Route::middleware(['auth', 'role:it_staff'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('courses', CourseController::class); // Add/Edit/Delete Courses
});

// LECTURER ROUTES
Route::middleware(['auth', 'role:lecturer'])->prefix('lecturer')->group(function () {
    Route::get('/courses', [LecturerController::class, 'assignedCourses'])->name('lecturer.courses');
    Route::get('/courses/{course}/students', [LecturerController::class, 'studentList']);
});

// STUDENT ROUTES
Route::middleware(['auth', 'role:student'])->prefix('student')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
    Route::get('/register', [RegistrationController::class, 'create'])->name('student.register');
    Route::delete('/register/{id}', [RegistrationController::class, 'destroy'])->name('student.register.destroy');
    Route::post('/register', [RegistrationController::class, 'store'])->name('student.register.store');;
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Search Courses (AJAX endpoint)
    Route::get('/student/courses/search', [StudentController::class, 'searchCourses'])
        ->name('student.courses.search');

    // Update Registration (Modify)
    Route::put('/student/registrations/{id}', [StudentController::class, 'updateRegistration'])
        ->name('student.registration.update');

    // Update Profile
    Route::put('/student/profile', [StudentController::class, 'updateProfile'])
        ->name('student.profile.update');

    // View enrolled courses (list view)
    Route::get('/student/courses', [StudentController::class, 'viewCourses'])
        ->name('student.courses.index');

    // View single course details
    Route::get('/student/courses/{id}', [StudentController::class, 'courseDetails'])
        ->name('student.courses.show');
});

require __DIR__.'/auth.php';
