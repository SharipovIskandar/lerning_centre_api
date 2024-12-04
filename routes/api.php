<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);


Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::post('/', [AdminController::class, 'store']);
    Route::get('{id}', [AdminController::class, 'show']);
    Route::patch('{id}', [AdminController::class, 'update']);
    Route::delete('{id}', [AdminController::class, 'destroy']);
});

Route::prefix('teacher')->group(function () {
    Route::get('/', [TeacherController::class, 'index']);
    Route::post('/', [TeacherController::class, 'store']);
    Route::get('{id}', [TeacherController::class, 'show']);
    Route::patch('{id}', [TeacherController::class, 'update']);
    Route::delete('{id}', [TeacherController::class, 'destroy']);
});

Route::prefix('student')->group(function () {
    Route::get('/', [StudentController::class, 'index']);
    Route::post('/', [StudentController::class, 'store']);
    Route::get('{id}', [StudentController::class, 'show']);
    Route::patch('{id}', [StudentController::class, 'update']);
    Route::delete('{id}', [StudentController::class, 'destroy']);
});

use App\Http\Controllers\ScheduleController;

Route::prefix('schedules')->group(function () {
    Route::get('/', [ScheduleController::class, 'index']);
    Route::post('/', [ScheduleController::class, 'store']);
    Route::get('/{id}', [ScheduleController::class, 'show']);
    Route::patch('/{id}', [ScheduleController::class, 'update']);
    Route::delete('/{id}', [ScheduleController::class, 'destroy']);
});
