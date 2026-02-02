<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LecturerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================================
// IT STAFF ROUTES (Course & Registration Management)
// ==========================================
Route::middleware(['auth', 'role:it_staff'])->prefix('admin')->name('admin.')->group(function () {
    // 1. Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // 2. Course Management (Add, Modify, Delete)
    Route::get('/courses', [AdminController::class, 'coursesList'])->name('courses.index'); // Optional: List view
    Route::get('/courses/create', [AdminController::class, 'createCourse'])->name('courses.create');
    Route::post('/courses', [AdminController::class, 'storeCourse'])->name('courses.store');
    Route::get('/courses/{course}/edit', [AdminController::class, 'editCourse'])->name('courses.edit');
    Route::put('/courses/{course}', [AdminController::class, 'updateCourse'])->name('courses.update');
    Route::delete('/courses/{course}', [AdminController::class, 'destroyCourse'])->name('courses.destroy');

    // 3. Amend Registration (Add/Remove students from courses)
    Route::get('/courses/{course}/registrations', [AdminController::class, 'manageRegistrations'])->name('registrations.manage');
    Route::post('/courses/{course}/registrations', [AdminController::class, 'storeRegistration'])->name('registrations.store');
    // [FIX] Status Update Route for the Dashboard Approve/Reject buttons
Route::patch('/registrations/{registration}/status', [AdminController::class, 'updateRegistrationStatus'])->name('registrations.status');
    Route::delete('/registrations/{registration}', [AdminController::class, 'destroyRegistration'])->name('registrations.destroy');
});

// ==========================================
// LECTURER ROUTES (View Courses & Student Details)
// ==========================================
Route::middleware(['auth', 'role:lecturer'])->prefix('lecturer')->name('lecturer.')->group(function () {
    // 1. View Assigned Courses
    Route::get('/dashboard', [LecturerController::class, 'dashboard'])->name('dashboard');
    // Dedicated Lecturer Profile Routes
    Route::get('/profile', [LecturerController::class, 'editProfile'])->name('profile.edit');
    Route::patch('/profile', [LecturerController::class, 'updateProfile'])->name('profile.update');
    // 2. View Course Details (includes Student List)
    Route::get('/course/{course}', [LecturerController::class, 'showCourse'])->name('course.show');

    // 3. View Student Details (extends Student List)
    Route::get('/course/{course}/student/{student}', [LecturerController::class, 'showStudent'])->name('student.show');
});

// ==========================================
// STUDENT ROUTES
// ==========================================
Route::middleware(['auth', 'role:student'])->prefix('student')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
    Route::get('/register', [RegistrationController::class, 'create'])->name('student.register');
    Route::delete('/register/{id}', [RegistrationController::class, 'destroy'])->name('student.register.destroy');
    Route::post('/register', [RegistrationController::class, 'store'])->name('student.register.store');
    
    // Search Courses (AJAX endpoint)
    Route::get('/courses/search', [StudentController::class, 'searchCourses'])
        ->name('student.courses.search');

    // Update Registration (Modify)
    Route::put('/registrations/{id}', [StudentController::class, 'updateRegistration'])
        ->name('student.registration.update');

    // Update Profile
    Route::put('/profile', [StudentController::class, 'updateProfile'])
        ->name('student.profile.update');

    // View enrolled courses (list view)
    Route::get('/courses', [StudentController::class, 'viewCourses'])
        ->name('student.courses.index');

    // View single course details
    // Change .show to .course.details to match your Blade file
    Route::get('/courses/{id}', [StudentController::class, 'courseDetails'])
        ->name('student.course.details');
});

require __DIR__.'/auth.php';