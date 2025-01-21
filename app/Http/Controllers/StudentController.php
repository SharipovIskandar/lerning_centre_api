<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\CourseResource;
use App\Http\Resources\ScheduleResource;
use App\Http\Resources\UserResource;
use App\Models\Course;
use App\Models\Schedule;
use App\Models\User;
use App\Services\User\Contracts\iUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    protected iUserService $userService;

    public function __construct(iUserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = User::student()->with('roles')->paginate(10);

        if ($users->isEmpty()) {
            return error_response(null, __('messages.users_not_found'), 404);
        }

        return success_response(UserResource::collection($users), __('messages.users_found'));
    }

    public function show(Request $request)
    {
        $user = User::student()->with('roles')->find($request->id);

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
            ->whereHas('roles', function ($query) {
                $query->where('name', 'student');
            })
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

    public function showCourses()
    {
        $id = Auth::user()->id;
        $student = User::find($id);

        if (!$student) {
            return error_response(null, __('messages.user_not_found'), 404);
        }

        $courses = $student->courses;

        if ($courses->isEmpty()) {
            return error_response(null, __('messages.no_courses_found_for_student'), 404);
        }

        return success_response(CourseResource::collection($courses), __('messages.courses_of_the_student'));
    }

    public function showSchedule($id, $courseId)
    {
        $student = User::find($id);

        if (!$student) {
            return error_response(null, __('messages.user_not_found'), 404);
        }

        $course = Course::find($courseId);

        if (!$course) {
            return error_response(null, __('messages.course_not_found'), 404);
        }

        $schedule = Schedule::where('course_id', $courseId)
            ->whereHas('students', function ($query) use ($id) {
                $query->where('student_id', $id);
            })
            ->get();

        if ($schedule->isEmpty()) {
            return error_response(null, __('messages.no_schedule_found_for_student_and_course'), 404);
        }

        return success_response(ScheduleResource::collection($schedule), __('messages.schedule_for_student_and_course'));
    }
}
