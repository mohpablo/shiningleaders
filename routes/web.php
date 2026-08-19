<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminTeacherController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'role:parent'])->group(function () {
    Route::get('/parent/dashboard', [ParentController::class, 'dashboard'])->name('parent.dashboard');
    // Step 1: Add Student Info
    Route::get('/add-student', [StudentController::class, 'create'])->name('add-student');
    Route::post('/add-student', [StudentController::class, 'store'])->name('store-student');

    // Step 2: Select Courses for Student
    Route::get('/students/{student}/select-courses', [StudentController::class, 'selectCourses'])->name('select-courses');
    Route::post('/students/{student}/select-courses', [StudentController::class, 'storeCourses'])->name('store-courses');;
    // في ملف Routes (مثلاً web.php)
    Route::post('/student/{student}/course/add', [StudentController::class, 'addCourse'])->name('parent.student.course.add');
    Route::delete('/student/{student}/course/{course}/remove', [StudentController::class, 'removeCourse'])->name('parent.student.course.remove');

    Route::get('/parent/courses', [ParentController::class, 'courses'])->name('parent.courses');
    Route::get('/parent/payments', [ParentController::class, 'payments'])->name('parent.payments');
    Route::view('/parent/settings', 'parent.settings')->name('parent.settings');

    Route::get('/parent/students/{student}', [ParentController::class, 'show'])->name('parent.student.show');
    Route::post('/parent/students/{student}/subscribe', [ParentController::class, 'subscribe'])->name('parent.student.subscribe');
    Route::get('/parent/students/{student}/subscriptions/{subscription}/checkout', [ParentController::class, 'checkout'])->name('parent.student.subscription.checkout');
});

Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
    Route::get('/courses', [TeacherController::class, 'courses'])->name('courses');
    Route::get('/courses/{course}', [TeacherController::class, 'showCourse'])->name('courses.show');
    Route::get('/courses/{course}/groups/{group}', [TeacherController::class, 'showGroup'])->name('courses.groups.show');
    Route::post('/courses/{course}/groups/{group}/session/complete', [TeacherController::class, 'completeSession'])->name('courses.groups.session.complete');
    Route::post('/courses/{course}/groups/{group}/students/{student}/mark', [TeacherController::class, 'markStudent'])->name('courses.groups.students.mark');
});

Route::post('/paymob/callback', [\App\Http\Controllers\PaymobController::class, 'callback'])->name('paymob.callback');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('courses', [\App\Http\Controllers\AdminCourseController::class, 'index'])->name('course');
    Route::get('courses/create', [\App\Http\Controllers\AdminCourseController::class, 'create'])->name('course.create');
    Route::post('courses', [\App\Http\Controllers\AdminCourseController::class, 'store'])->name('course.store');
    Route::get('courses/{course}/edit', [\App\Http\Controllers\AdminCourseController::class, 'edit'])->name('course.edit');
    Route::put('courses/{course}', [\App\Http\Controllers\AdminCourseController::class, 'update'])->name('course.update');
    Route::delete('courses/{course}', [\App\Http\Controllers\AdminCourseController::class, 'destroy'])->name('course.destroy');

    Route::post('courses/{course}/groups', [\App\Http\Controllers\AdminCourseController::class, 'storeGroup'])->name('course.groups.store');
    Route::delete('courses/{course}/groups/{group}', [\App\Http\Controllers\AdminCourseController::class, 'destroyGroup'])->name('course.groups.destroy');

    Route::get('parents', [\App\Http\Controllers\AdminParentController::class, 'index'])->name('parents.index');
    Route::get('parents/{parent}', [\App\Http\Controllers\AdminParentController::class, 'show'])->name('parents.show');
    Route::delete('parents/{parent}', [\App\Http\Controllers\AdminParentController::class, 'destroy'])->name('parents.destroy');

    Route::get('programs', [AdminTeacherController::class, 'index'])->name('programs.index');
    Route::get('programs/create', [AdminTeacherController::class, 'create'])->name('programs.create');
    Route::post('programs', [AdminTeacherController::class, 'store'])->name('programs.store');
    Route::get('programs/{teacher}/edit', [AdminTeacherController::class, 'edit'])->name('programs.edit');
    Route::put('programs/{teacher}', [AdminTeacherController::class, 'update'])->name('programs.update');
    Route::delete('programs/{teacher}', [AdminTeacherController::class, 'destroy'])->name('programs.destroy');

    Route::view('settings', 'admin.settings')->name('settings');
});
