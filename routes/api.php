<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamResultController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ScheduleController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);

Route::group(['middleware' => ['auth:sanctum', 'lang']], function () {
    Route::prefix('admins')->middleware('role:admin')->group(function () {
        Route::get('/', [AdminController::class, 'index']);
        Route::post('/', [AdminController::class, 'store']);
        Route::get('/profile', [AdminController::class, 'showProfile']);
        Route::patch('/{id}/profile', [AdminController::class, 'updateProfile']);
        Route::get('/{id}', [AdminController::class, 'show']);
        Route::patch('/{id}', [AdminController::class, 'update']);
        Route::delete('/{id}', [AdminController::class, 'destroy']);
    });

    Route::prefix('students')->middleware('role:admin')->group(function () {
        Route::get('/', [StudentController::class, 'index']);
        Route::post('/', [StudentController::class, 'store']);
        Route::get('/{id}', [StudentController::class, 'showForAdmin']);
        Route::patch('/{id}', [StudentController::class, 'update']);
        Route::delete('/{id}', [StudentController::class, 'destroy']);
    });

    Route::prefix('teachers')->middleware('role:admin')->group(function () {
        Route::get('/', [TeacherController::class, 'index']);
        Route::post('/', [TeacherController::class, 'store']);
        Route::get('/{id}', [TeacherController::class, 'showForAdmin']);
        Route::patch('/{id}', [TeacherController::class, 'update']);
        Route::delete('/{id}', [TeacherController::class, 'destroy']);
    });

    Route::prefix('teacher')->middleware('role:teacher')->group(function () {
        Route::get('/', [TeacherController::class, 'show']);
        Route::get('/profile', [TeacherController::class, 'showProfile']);
        Route::patch('/{id}/profile', [TeacherController::class, 'updateProfile']);
        Route::get('/schedule/{courseId}', [TeacherController::class, 'showSchedule']);
        Route::get('/students/{courseId}', [TeacherController::class, 'showStudents']);
    });

    Route::prefix('student')->middleware('role:student')->group(function () {
        Route::get('/', [StudentController::class, 'show']);
        Route::get('/profile', [StudentController::class, 'showProfile']);
        Route::patch('/{id}/profile', [StudentController::class, 'updateProfile']);
        Route::get('/courses', [StudentController::class, 'showCourses']);
        Route::get('/{id}/schedule/{courseId}', [StudentController::class, 'showSchedule']);
    });

    Route::prefix('schedules')->middleware('role:admin')->group(function () {
        Route::get('/', [ScheduleController::class, 'index']);
        Route::post('/', [ScheduleController::class, 'store']);
        Route::get('/{id}', [ScheduleController::class, 'show']);
        Route::patch('/{id}', [ScheduleController::class, 'update']);
        Route::delete('/{id}', [ScheduleController::class, 'destroy']);
    });
    Route::prefix('exams')->middleware('role:teacher')->group(function () {
        Route::get('/', [ExamController::class, 'index']);
        Route::post('/', [ExamController::class, 'store']);
        Route::get('/{exam}', [ExamController::class, 'show']);
        Route::put('/{exam}', [ExamController::class, 'update']);
        Route::delete('/{exam}', [ExamController::class, 'destroy']);
    });
    Route::prefix('payments')->middleware('role:admin')->group(function () {
        Route::get('/', [PaymentController::class, 'index']);
        Route::get('{payment}', [PaymentController::class, 'show']);
        Route::post('/', [PaymentController::class, 'store']);
        Route::put('{payment}', [PaymentController::class, 'update']);
        Route::delete('{payment}', [PaymentController::class, 'destroy']);
    });
    Route::prefix('exam/results')->middleware('role:teacher')->group(function () {
        Route::get('/', [ExamResultController::class, 'index']);
        Route::get('{id}', [ExamResultController::class, 'show']);
        Route::post('/', [ExamResultController::class, 'store']);
        Route::put('{id}', [ExamResultController::class, 'update']);
        Route::delete('{id}', [ExamResultController::class, 'destroy']);
    });
});
