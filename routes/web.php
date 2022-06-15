<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('mail', [WelcomeController::class, 'mail']);

Route::prefix('user')->name('user.')->group(function () {
    Route::get('login', [StudentController::class, 'showLogin'])->name('login.show');
    Route::post('login', [StudentController::class, 'login'])->name('login');

    Route::get('forgetPassword', [StudentController::class, 'showForgetPasswordForm'])->name('forgetpassword.show');
    Route::post('forgetPassword', [StudentController::class, 'submitForgetPasswordForm'])->name('forgetpassword');
    Route::get('resetPassword/{token}', [StudentController::class, 'showResetPasswordForm'])->name('resetpassword.show');
    Route::post('resetPassword', [StudentController::class, 'submitResetPasswordForm'])->name('resetpassword');

    Route::middleware('auth')->group(function () {
        Route::get('list', [StudentController::class, 'show'])->name('list');
        Route::get('details/{id}', [StudentController::class, 'showDetails'])->name('detail');

        Route::get('update/{id}', [StudentController::class, 'showUpdate'])->name('update.show');
        Route::post('update', [StudentController::class, 'update'])->name('update');

        Route::get('register', [StudentController::class, 'showRegister'])->name('register.show');
        Route::post('register', [StudentController::class, 'register'])->name('register');

        Route::get('delete/{id}', [StudentController::class, 'delete'])->name('delete');

        Route::get('change_password/{id}', [StudentController::class, 'showPassword'])->name('change_password.show');
        Route::post('change_password', [StudentController::class, 'checkPassword'])->name('change_password');

        Route::post('search', [StudentController::class, 'search'])->name('search');
    });

    Route::middleware('auth:student')->group(function () {
        Route::get('logout', [StudentController::class, 'logout'])->name('logout');

        Route::get('profile', [StudentController::class, 'profile'])->name('profile.show');

        Route::get('profileEdit', [StudentController::class, 'showProfileEdit'])->name('profileEdit.show');
        Route::post('profileEdit', [StudentController::class, 'profileEdit'])->name('profileEdit');

        Route::get('profileDelete', [StudentController::class, 'profileDelete'])->name('profileDelete');
    });
});

Route::prefix('course')->name('course.')->group(function () {
    Route::get('list', [CourseController::class, 'show'])->name('list');
    Route::get('details/{id}', [CourseController::class, 'showDetails'])->name('detail');

    Route::middleware('auth')->group(function () {
        Route::get('update/{id}', [CourseController::class, 'showUpdate'])->name('update.show');
        Route::post('update', [CourseController::class, 'update'])->name('update');

        Route::get('create', [CourseController::class, 'showCreate'])->name('create.show');
        Route::post('create', [CourseController::class, 'create'])->name('create');

        Route::get('delete/{id}', [CourseController::class, 'delete'])->name('delete');
    });

    Route::post('search', [CourseController::class, 'search'])->name('search');
});

Route::prefix('teacher')->name('teacher.')->group(function () {
    Route::get('login', [TeacherController::class, 'showLogin'])->name('login.show');
    Route::post('login', [TeacherController::class, 'login'])->name('login');

    Route::get('forgetPassword', [TeacherController::class, 'showForgetPasswordForm'])->name('forgetpassword.show');
    Route::post('forgetPassword', [TeacherController::class, 'submitForgetPasswordForm'])->name('forgetpassword');
    Route::get('resetPassword/{token}', [TeacherController::class, 'showResetPasswordForm'])->name('resetpassword.show');
    Route::post('resetPassword', [TeacherController::class, 'submitResetPasswordForm'])->name('resetpassword');

    Route::middleware('auth')->group(function () {

        Route::get('list', [TeacherController::class, 'show'])->name('list');
        Route::get('details/{id}', [TeacherController::class, 'showDetails'])->name('details');

        Route::get('update/{id}', [TeacherController::class, 'showUpdate'])->name('update.show');
        Route::post('update', [TeacherController::class, 'update'])->name('update');

        Route::get('create', [TeacherController::class, 'showCreate'])->name('create.show');
        Route::post('create', [TeacherController::class, 'create'])->name('create');

        Route::get('delete/{id}', [TeacherController::class, 'delete'])->name('delete');

        Route::get('change_password/{id}', [TeacherController::class, 'showPassword'])->name('change_password.show');
        Route::post('change_password', [TeacherController::class, 'checkPassword'])->name('change_password');

        Route::post('search', [TeacherController::class, 'search'])->name('search');

        Route::get('logout', [TeacherController::class, 'logout'])->name('logout');

        Route::get('profile', [TeacherController::class, 'profile'])->name('profile.show');

        Route::get('profileEdit', [TeacherController::class, 'showProfileEdit'])->name('profileEdit.show');
        Route::post('profileEdit', [TeacherController::class, 'profileEdit'])->name('profileEdit');

        Route::get('profileDelete', [TeacherController::class, 'profileDelete'])->name('profileDelete');
    });
});
