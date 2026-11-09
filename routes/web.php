<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseRegistrationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Authentication Routes (Question 3a)
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('home');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Authenticated Routes (Protected by auth middleware - Question 3d)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 1. Role-specific Dashboards
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
    });

    Route::middleware('role:lecturer')->prefix('lecturer')->name('lecturer.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'lecturerDashboard'])->name('dashboard');
    });

    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'studentDashboard'])->name('dashboard');
    });

    // 2. Student CRUD Operations (Question 4a)
    Route::resource('students', StudentController::class);

    // 3. Course CRUD Operations (Question 4b)
    Route::resource('courses', CourseController::class);

    // 4. Course Registrations (Question 4c)
    Route::resource('registrations', CourseRegistrationController::class)->only([
        'index', 'create', 'store', 'destroy'
    ]);
});
