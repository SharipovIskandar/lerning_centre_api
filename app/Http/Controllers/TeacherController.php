<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Models\User;
use App\Models\Schedule;
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

    public function show()
    {
        $userId = Auth::id();
        $user = User::teacher()->find($userId);

        if (!$user) {
            return error_response(null, __('messages.user_not_found'), 404);
        }

        return success_response(new UserResource($user), __('messages.user_details'));
    }

    public function showForAdmin(TeacherRequest $request)
    {
        dd($request);
        $userId = $request->id;
        $user = User::query()->find($userId);

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

    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->userService->update($request, $id);
        return success_response(new UserResource($user), __('messages.user_updated'));
    }

    public function destroy(Request $request)
    {
        $user = $this->userService->destroy($request);
        return success_response(new UserResource($user), __('messages.user_deleted'));
    }

    public function showCourses(TeacherRequest $request)
    {
        $teacher = User::find($request->id);

        if (!$teacher) {
            return error_response(null, __('messages.user_not_found'), 404);
        }

        $courses = $teacher->courses;

        if ($courses->isEmpty()) {
            return error_response(null, __('messages.no_courses_found'), 404);
        }

        return success_response(CourseResource::collection($courses), __('messages.courses_of_teacher'));
    }

    public function showSchedule(TeacherRequest $request)
    {
        $teacher = User::find($request->id);

        if (!$teacher) {
            return error_response(null, __('messages.user_not_found'), 404);
        }

        $course = Course::find($request->course_id);

        if (!$course) {
            return error_response(null, __('messages.course_not_found'), 404);
        }

        $schedule = Schedule::where('teacher_id', $request->id)
            ->where('course_id', $request->course_id)
            ->get();

        if ($schedule->isEmpty()) {
            return error_response(null, __('messages.no_schedule_found'), 404);
        }

        return success_response($schedule, __('messages.schedule_for_teacher_course'));
    }

    public function showStudents(TeacherRequest $request)
    {
        $teacher = User::find($request->id);

        if (!$teacher) {
            return error_response(null, __('messages.user_not_found'), 404);
        }

        $course = Course::find($request->course_id);

        if (!$course) {
            return error_response(null, __('messages.course_not_found'), 404);
        }

        $students = $course->students;

        if ($students->isEmpty()) {
            return error_response(null, __('messages.no_students_found'), 404);
        }

        return success_response(UserResource::collection($students), __('messages.students_in_course'));
    }
}
