<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Course;
use App\Models\Schedule;
use App\Models\User;
use App\Services\User\Contracts\iUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    protected iUserService $userService;

    public function __construct(iUserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = User::teacher()->with('roles')->paginate(10);

        if ($users->isEmpty()) {
            return error_response(null, __('messages.users_not_found'), 404);
        }

        return success_response(UserResource::collection($users), __('messages.users_found'));
    }

    public function show(Request $request)
    {
        $user = User::teacher()->with('roles')->find($request->id);

        if (!$user) {
            return error_response(null, __('messages.user_not_found'), 404);
        }

        return success_response(new UserResource($user), __('messages.user_details'));
    }

    public function showForAdmin(Request $request)
    {
        $userId = $request->id;
        $user = User::query()
            ->with('roles')
            ->whereHas('roles', fn($query) => $query->where('name', 'teacher'))
            ->find($userId);

        if (!$user) {
            return error_response(null, __('messages.user_not_found'), 404);
        }

        return success_response(new UserResource($user), __('messages.user_details'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->store($request);
        return success_response(new UserResource($user), __('messages.user_created'));
    }

    public function update(UpdateUserRequest $request)
    {
        $user = $this->userService->update($request);
        return success_response(new UserResource($user), __('messages.user_updated'));
    }

    public function destroy(Request $request)
    {
        $user = $this->userService->destroy($request);
        return success_response(new UserResource($user), __('messages.user_deleted'));
    }

    public function showCourses($id)
    {
        $teacher = User::find($id);

        if (!$teacher) {
            return error_response(null, __('messages.user_not_found'), 404);
        }

        $courses = $teacher->courses;

        if ($courses->isEmpty()) {
            return error_response(null, __('messages.no_courses_found'), 404);
        }

        return success_response($courses, __('messages.courses_of_teacher'));
    }

    public function showSchedule($courseId)
    {
        $id = Auth::user()->id;
        $teacher = User::find($id);

        if (!$teacher) {
            return error_response(null, __('messages.user_not_found'), 404);
        }

        $course = Course::find($courseId);

        if (!$course) {
            return error_response(null, __('messages.course_not_found'), 404);
        }

        $schedule = Schedule::where('teacher_id', $id)
            ->where('course_id', $courseId)
            ->get();

        if ($schedule->isEmpty()) {
            return error_response(null, __('messages.no_schedule_found'), 404);
        }

        return success_response($schedule, __('messages.schedule_for_teacher_course'));
    }

    public function showStudents($courseId)
    {
        $id = Auth::user()->id;
        $teacher = User::find($id);

        if (!$teacher) {
            return error_response(null, __('messages.user_not_found'), 404);
        }

        $course = Course::find($courseId);

        if (!$course) {
            return error_response(null, __('messages.course_not_found'), 404);
        }

        $students = $course->students;

        if ($students->isEmpty()) {
            return error_response(null, __('messages.no_students_found'), 404);
        }

        return success_response($students, __('messages.students_in_course'));
    }
}
