<?php

use App\Http\Controllers\AuthController;
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

Route::group(['middleware' => 'auth:sanctum'], function () {
Route::prefix('admin')->middleware(['role:admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::post('/', [AdminController::class, 'store']);
    Route::get('{id}', [AdminController::class, 'show']);
    Route::patch('{id}', [AdminController::class, 'update']);
    Route::delete('{id}', [AdminController::class, 'destroy']);
});
Route::group(['middleware' => 'role:admin'], function () {
    Route::prefix('student')->group(function () {
        Route::post('/', [StudentController::class, 'store']);
        Route::get('{id}', [StudentController::class, 'show']);
        Route::patch('{id}', [StudentController::class, 'update']);
        Route::delete('{id}', [StudentController::class, 'destroy']);
    });
});
Route::group(['middleware' => 'role:admin'], function () {
    Route::prefix('teacher')->group(function () {
        Route::post('/', [TeacherController::class, 'store']);
        Route::get('{id}', [TeacherController::class, 'show']);
        Route::patch('{id}', [TeacherController::class, 'update']);
        Route::delete('{id}', [TeacherController::class, 'destroy']);
    });
});
Route::prefix('teacher')->middleware(['role:teacher'])->group(function () {
    Route::get('{id}', [TeacherController::class, 'show']);
    Route::get('/{id}/courses', [TeacherController::class, 'showCourses']);
    Route::get('/{id}/schedule/{courseId}', [TeacherController::class, 'showSchedule']);
    Route::get('/{id}/students/{courseId}', [TeacherController::class, 'showStudents']);
});
Route::prefix('student')->middleware(['role:student'])->group(function () {
    Route::get('{id}', [StudentController::class, 'show']);
    Route::get('/{id}/courses', [StudentController::class, 'showCourses']);
    Route::get('/{id}/schedule/{courseId}', [StudentController::class, 'showSchedule']);
});
    Route::prefix('schedules')->middleware('role:admin')->group(function () {
        Route::get('/', [ScheduleController::class, 'index']);
        Route::post('/', [ScheduleController::class, 'store']);
        Route::get('/{id}', [ScheduleController::class, 'show']);
        Route::patch('/{id}', [ScheduleController::class, 'update']);
        Route::delete('/{id}', [ScheduleController::class, 'destroy']);
    });
});
