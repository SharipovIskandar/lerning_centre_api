<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Course;
use App\Models\Role;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function store(StoreUserRequest $request)
    {
        return app(UserController::class)->store($request);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        return app(UserController::class)->update($request, $user);
    }

    public function show(UpdateUserRequest $user)
    {
        return app(UserController::class)->show($user->id);
    }

    public function destroy(Request $user)
    {
        return app(UserController::class)->destroy($user);
    }

    public function index()
    {
        $roleId = Role::where('key', 'teacher')->first()?->id;

        if (!$roleId) {
            return response()->json(['message' => 'No data found'], 404);
        }

        $teachers = User::whereHas('roles', function ($query) use ($roleId) {
            $query->where('role_id', $roleId);
        })->get();

        if ($teachers->isEmpty()) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return UserResource::collection($teachers);
    }

    public function showCourses($teacherId)
    {
        $teacher = User::find($teacherId);
        if (!$teacher) {
            return response()->json(['message' => 'Teacher not found'], 404);
        }

        $courses = $teacher->courses;
        return response()->json($courses);
    }

    public function showSchedule($teacherId, $courseId)
    {
        $teacher = User::find($teacherId);
        if (!$teacher) {
            return response()->json(['message' => 'Teacher not found'], 404);
        }

        $schedule = Schedule::where('course_id', $courseId)
            ->where('teacher_id', $teacher->id)
            ->get();
        return response()->json($schedule);
    }

    public function showStudents($teacherId, $courseId)
    {
        $teacher = User::find($teacherId);
        if (!$teacher) {
            return response()->json(['message' => 'Teacher not found'], 404);
        }

        $course = Course::find($courseId);
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $students = $course->users;
        return response()->json($students);
    }
}
