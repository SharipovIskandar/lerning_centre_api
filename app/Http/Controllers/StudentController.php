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

class StudentController extends Controller
{
    protected iUserService $userService;

    public function __construct(iUserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = User::query()
            ->with('roles')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'student');
            })
            ->get();

        if ($users->isEmpty()) {
            return error_response(null, 'No student users found', 404);
        }

        return success_response(UserResource::collection($users), "All student users");
    }


    public function show()
    {
        $userId = Auth::id();

        $user = User::query()
            ->with('roles')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'student');
            })
            ->find($userId);

        if (!$user) {
            return error_response(null, 'student user not found (or u are not student)', 404);
        }

        return success_response(new UserResource($user), 'student user details');
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
            return error_response(null, 'student user not found', 404);
        }

        return success_response(new UserResource($user), 'student user details');
    }


    public function store(StoreUserRequest $request)
    {
        return $this->userService->store($request);
    }

    public function update(UpdateUserRequest $request)
    {
        return $this->userService->update($request);
    }

    public function destroy(Request $request)
    {
        return $this->userService->destroy($request);
    }

    public function showCourses()
    {
        $id = Auth::user()->id;
        $student = User::find($id);

        if (!$student) {
            return error_response(null, 'Student not found', 404);
        }

        $courses = $student->courses;

        if ($courses->isEmpty()) {
            return error_response(null, 'No courses found for this student', 404);
        }

        return success_response($courses, 'Courses of the student');
    }

    public function showSchedule($courseId)
    {
        $id = Auth::user()->id;
        $student = User::find($id);

        if (!$student) {
            return error_response(null, 'Student not found', 404);
        }

        $course = Course::find($courseId);

        if (!$course) {
            return error_response(null, 'Course not found', 404);
        }

        $schedule = Schedule::where('course_id', $courseId)
            ->whereHas('students', function ($query) use ($id) {
                $query->where('user_id', $id);
            })
            ->get();

        if ($schedule->isEmpty()) {
            return error_response(null, 'No schedule found for this student and course', 404);
        }

        return success_response($schedule, 'Schedule for the student and course');
    }

    public function showProfile(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        return success_response(new UserResource($user), 'Profile info');
    }

    public function updateProfile(UpdateUserRequest $request): \Illuminate\Http\JsonResponse
    {
        $student = Auth::user();
        if (!$student) {
            return error_response([], 'Student not found', 404);
        }

        $validated = $request->validated();

        $profilePhotoPath = $student->profile_photo;

        if ($request->hasFile('profile_photo')) {
            $profilePhoto = $request->file('profile_photo');
            if ($profilePhoto->isValid()) {
                $profilePhotoName = uniqid('profile_', true) . '.' . $profilePhoto->getClientOriginalExtension();
                $profilePhotoPath = $profilePhoto->storeAs('profile_photos', $profilePhotoName, 'public'); // Faylni saqlash
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

        return success_response(new UserResource($student), 'Student profile updated successfully');
    }
}
