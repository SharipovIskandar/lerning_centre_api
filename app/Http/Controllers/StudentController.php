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
use Illuminate\Http\JsonResponse;

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
            return error_response(null, __('messages.no_student_users'), 404);
        }

        return success_response(UserResource::collection($users), __('messages.student_users_found'));
    }

    public function show(Request $request)
    {
        $user = User::student()->with('roles')->find($request->id);

        if (!$user) {
            return error_response(null, __('messages.student_user_not_found'), 404);
        }

        return success_response(new UserResource($user), __('messages.student_user_details'));
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
            return error_response(null, __('messages.student_not_found'), 404);
        }

        return success_response(new UserResource($user), __('messages.student_user_details'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->store($request);
        return success_response(new UserResource($user), __('messages.student_user_created'));
    }

    public function update(UpdateUserRequest $request)
    {
        $user = $this->userService->update($request);
        return success_response(new UserResource($user), __('messages.student_user_updated'));
    }

    public function destroy(Request $request)
    {
        $user = $this->userService->destroy($request);
        return success_response(new UserResource($user), __('messages.student_user_deleted'));
    }

    public function showCourses()
    {
        $id = Auth::user()->id;
        $student = User::find($id);

        if (!$student) {
            return error_response(null, __('messages.student_not_found'), 404);
        }

        $courses = $student->courses;

        if ($courses->isEmpty()) {
            return error_response(null, __('messages.no_courses_found_for_student'), 404);
        }

        return success_response($courses, __('messages.courses_of_the_student'));
    }

    public function showSchedule($courseId)
    {
        $id = Auth::user()->id;
        $student = User::find($id);

        if (!$student) {
            return error_response(null, __('messages.student_not_found'), 404);
        }

        $course = Course::find($courseId);

        if (!$course) {
            return error_response(null, __('messages.course_not_found'), 404);
        }

        $schedule = Schedule::where('course_id', $courseId)
            ->whereHas('students', function ($query) use ($id) {
                $query->where('user_id', $id);
            })
            ->get();

        if ($schedule->isEmpty()) {
            return error_response(null, __('messages.no_schedule_found_for_student_and_course'), 404);
        }

        return success_response($schedule, __('messages.schedule_for_student_and_course'));
    }

    public function showProfile(): JsonResponse
    {
        $user = Auth::user();
        return success_response(new UserResource($user), __('messages.profile_info'));
    }

    public function updateProfile(UpdateUserRequest $request): JsonResponse
    {
        $student = Auth::user();
        if (!$student) {
            return error_response([], __('messages.student_not_found'), 404);
        }

        $validated = $request->validated();

        $profilePhotoPath = $student->profile_photo;

        if ($request->hasFile('profile_photo')) {
            $profilePhoto = $request->file('profile_photo');
            if ($profilePhoto->isValid()) {
                $profilePhotoName = uniqid('profile_', true) . '.' . $profilePhoto->getClientOriginalExtension();
                $profilePhotoPath = $profilePhoto->storeAs('profile_photos', $profilePhotoName, 'public');
            }
        }

        $student->update([
            'first_name' => $validated['first_name'] ?? $student->first_name,
            'last_name' => $validated['last_name'] ?? $student->last_name,
            'pinfl' => $validated['pinfl'] ?? $student->pinfl,
            'email' => $validated['email'] ?? $student->email,
            'password' => !empty($validated['password']) ? bcrypt($validated['password']) : $student->password,
            'profile_photo' => $profilePhotoPath,
        ]);

        return success_response(new UserResource($student), __('messages.student_profile_updated'));
    }
}
