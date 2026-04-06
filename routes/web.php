<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.profiles')
            : redirect()->route('student.dashboard');
    }
    return view('welcome');
});

/* ─── Authenticated routes ─── */
Route::middleware(['auth', 'verified'])->group(function () {

    /* Profile */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Google Calendar Routes
    Route::get('/google/redirect', [\App\Http\Controllers\GoogleCalendarController::class, 'redirect'])->name('google.redirect');
    Route::get('/google/callback', [\App\Http\Controllers\GoogleCalendarController::class, 'callback'])->name('google.callback');
    Route::post('/schedule/{schedule}/sync-google', [\App\Http\Controllers\GoogleCalendarController::class, 'sync'])->name('google.sync');


    /* ── Admin ── */
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/profiles', [AdminController::class, 'profiles'])->name('profiles');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::get('/courses', [AdminController::class, 'courses'])->name('courses');
        Route::get('/courses/create', [AdminController::class, 'createCourse'])->name('courses.create');
        Route::post('/courses', [AdminController::class, 'storeCourse'])->name('courses.store');
        Route::get('/courses/{course}/edit', [AdminController::class, 'editCourse'])->name('courses.edit');
        Route::put('/courses/{course}', [AdminController::class, 'updateCourse'])->name('courses.update');
        Route::delete('/courses/{course}', [AdminController::class, 'destroyCourse'])->name('courses.destroy');

        Route::get('/schedules', [AdminController::class, 'schedules'])->name('schedules');
        Route::get('/schedules/{schedule}', [AdminController::class, 'showSchedule'])->name('schedules.show');

        Route::get('/students', [AdminController::class, 'students'])->name('students');
    });

    /* ── Student ── */
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');

        // Manajemen Mata Kuliah (semua jadwal)
        Route::get('/mata-kuliah', [StudentController::class, 'indexCourses'])->name('courses.index');

        // Upload (blocked if schedule exists)
        Route::get('/upload', [StudentController::class, 'uploadForm'])->name('upload');
        Route::post('/upload', [StudentController::class, 'upload'])->name('upload.store');

        // Schedule CRUD
        Route::get('/schedule/{schedule}', [StudentController::class, 'show'])->name('schedule.show');
        Route::get('/schedule/{schedule}/edit', [StudentController::class, 'editSchedule'])->name('schedule.edit');
        Route::put('/schedule/{schedule}', [StudentController::class, 'updateSchedule'])->name('schedule.update');
        Route::delete('/schedule/{schedule}', [StudentController::class, 'destroy'])->name('schedule.destroy');

        // Course CRUD within a schedule
        Route::get('/schedule/{schedule}/course/create', [StudentController::class, 'createCourse'])->name('course.create');
        Route::post('/schedule/{schedule}/course', [StudentController::class, 'storeCourse'])->name('course.store');
        Route::get('/schedule/{schedule}/course/{course}/edit', [StudentController::class, 'editCourse'])->name('course.edit');
        Route::put('/schedule/{schedule}/course/{course}', [StudentController::class, 'updateCourse'])->name('course.update');
        Route::delete('/schedule/{schedule}/course/{course}', [StudentController::class, 'destroyCourse'])->name('course.destroy');

        // Activity CRUD (Jobs/Freelance)
        Route::get('/activities', [StudentController::class, 'indexActivities'])->name('activities.index');
        Route::get('/activities/create', [StudentController::class, 'createActivity'])->name('activities.create');
        Route::post('/activities', [StudentController::class, 'storeActivity'])->name('activities.store');
        Route::get('/activities/{activity}/edit', [StudentController::class, 'editActivity'])->name('activities.edit');
        Route::put('/activities/{activity}', [StudentController::class, 'updateActivity'])->name('activities.update');
        Route::delete('/activities/{activity}', [StudentController::class, 'destroyActivity'])->name('activities.destroy');
    });
});

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Public Profile Routes — MUST be last to avoid route conflicts
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\PublicProfileController;

Route::get('/{username}', [PublicProfileController::class, 'show'])
    ->name('public.profile')
    ->where('username', '[a-zA-Z0-9_\-]+');
