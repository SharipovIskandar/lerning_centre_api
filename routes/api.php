<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseStudentController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamResultController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\HomeworkEvaluationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherCourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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
        Route::post('/', [PaymentController::class, 'store']);
        Route::get('{payment}', [PaymentController::class, 'show']);
        Route::put('{payment}', [PaymentController::class, 'update']);
        Route::delete('{payment}', [PaymentController::class, 'destroy']);
    });
    Route::prefix('exam/results')->middleware('role:teacher')->group(function () {
        Route::get('/', [ExamResultController::class, 'index']);
        Route::post('/', [ExamResultController::class, 'store']);
        Route::get('{id}', [ExamResultController::class, 'show']);
        Route::put('{id}', [ExamResultController::class, 'update']);
        Route::delete('{id}', [ExamResultController::class, 'destroy']);
    });
    Route::prefix('teacher/courses')->middleware('role:admin')->group(function () {
        Route::get('/', [TeacherCourseController::class, 'index']);
        Route::post('/', [TeacherCourseController::class, 'store']);
        Route::get('/{id}', [TeacherCourseController::class, 'edit']);
        Route::put('/{id}', [TeacherCourseController::class, 'update']);
        Route::delete('/{id}', [TeacherCourseController::class, 'destroy']);
    });
    Route::prefix('course/students')->middleware('role:admin')->group(function () {
        Route::get('/', [CourseStudentController::class, 'index']);
        Route::post('/', [CourseStudentController::class, 'store']);
        Route::get('/{id}', [CourseStudentController::class, 'show']);
        Route::put('/{id}', [CourseStudentController::class, 'update']);
        Route::patch('/{id}', [CourseStudentController::class, 'update']);
        Route::delete('/{id}', [CourseStudentController::class, 'destroy']);
    });
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'showProfile']);
        Route::post('/', [ProfileController::class, 'updateProfile']);
        Route::delete('/', [ProfileController::class, 'clearProfilePhotos']);
    });
    Route::prefix('courses/')->middleware('role:admin')->group(function () {
        Route::get('/', [CourseController::class, 'index']);
        Route::post('/', [CourseController::class, 'store']);
        Route::get('/{id}', [CourseController::class, 'show']);
        Route::put('/{id}', [CourseController::class, 'update']);
        Route::delete('/{id}', [CourseController::class, 'destroy']);
    });
    Route::prefix('rooms')->middleware('role:admin')->group(function () {
        Route::get('/', [RoomController::class, 'index']);
        Route::post('/', [RoomController::class, 'store']);
        Route::get('/{id}', [RoomController::class, 'show']);
        Route::put('/{id}', [RoomController::class, 'update']);
        Route::delete('/{id}', [RoomController::class, 'destroy']);
    });
    Route::prefix('homeworks')->middleware('role:teacher')->group(function () {
        Route::get('/', [HomeworkController::class, 'index']);
        Route::post('/', [HomeworkController::class, 'store']);
        Route::get('{id}', [HomeworkController::class, 'show']);
        Route::put('{id}', [HomeworkController::class, 'update']);
        Route::delete('{id}', [HomeworkController::class, 'destroy']);
    });
    Route::prefix('homework/evaluation')->middleware('role:teacher')->group(function () {
        Route::get('/', [HomeworkEvaluationController::class, 'index']);
        Route::post('/', [HomeworkEvaluationController::class, 'store']);
        Route::get('{id}', [HomeworkEvaluationController::class, 'show']);
        Route::put('{id}', [HomeworkEvaluationController::class, 'update']);
        Route::delete('{id}', [HomeworkEvaluationController::class, 'destroy']);
    });
    Route::prefix('attendance')->middleware('role:teacher')->group(function () {
        Route::get('/', [AttendanceController::class, 'index']);
        Route::post('/', [AttendanceController::class, 'store']);
        Route::get('{id}', [AttendanceController::class, 'show']);
        Route::put('{id}', [AttendanceController::class, 'update']);
        Route::delete('{id}', [AttendanceController::class, 'destroy']);
    });
});
