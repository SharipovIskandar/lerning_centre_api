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
        $users = User::query()
            ->with('roles')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'teacher');
            })
            ->get();
        if ($users->isEmpty()) {
            return error_response(null, 'No teacher users found', 404);
        }

        return success_response(UserResource::collection($users), "All teacher users");
    }
    public function showForAdmin(Request $request)
    {
        $userId = $request->id;
        $user = User::query()
            ->with('roles')
            ->whereHas('roles', fn($query) => $query->where('name', 'teacher'))
            ->find($userId);

        if (!$user) {
            return error_response(null, 'Teacher user not found', 404);
        }

        return success_response(new UserResource($user), 'Teacher user details');
    }

    public function show()
    {
        $userId = Auth::id();
        if(!$userId){
            return error_response(null, 'Maybe u are not teacher', 404);
        }
        $user = User::query()
            ->with('roles')
            ->whereHas('roles', fn($query) => $query->where('name', 'teacher'))
            ->find($userId);

        if (!$user) {
            return error_response(null, 'Teacher user not found (or u are not teacher)', 404);
        }

        return success_response(new UserResource($user), 'Teacher user details');
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

    public function showCourses($id)
    {
        $teacher = User::find($id);

        if (!$teacher) {
            return error_response(null, 'Teacher not found', 404);
        }

        $courses = $teacher->courses;

        if ($courses->isEmpty()) {
            return error_response(null, 'No courses found for this teacher', 404);
        }

        return success_response($courses, 'Courses of the teacher');
    }

    public function showSchedule($courseId)
    {
        $id = Auth::user()->id;
        $teacher = User::find($id);

        if (!$teacher) {
            return error_response(null, 'Teacher not found', 404);
        }

        $course = Course::find($courseId);

        if (!$course) {
            return error_response(null, 'Course not found', 404);
        }

        $schedule = Schedule::where('teacher_id', $id)
            ->where('course_id', $courseId)
            ->get();

        if ($schedule->isEmpty()) {
            return error_response(null, 'No schedule found for this teacher and course', 404);
        }

        return success_response($schedule, 'Schedule for the teacher and course');
    }

    public function showStudents($courseId)
    {
        $id = Auth::user()->id;
        $teacher = User::find($id);

        if (!$teacher) {
            return error_response(null, 'Teacher not found', 404);
        }

        $course = Course::find($courseId);

        if (!$course) {
            return error_response(null, 'Course not found', 404);
        }

        $students = $course->students;

        if ($students->isEmpty()) {
            return error_response(null, 'No students found for this course', 404);
        }

        return success_response($students, 'Students enrolled in the course');
    }
    public function showProfile(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        return success_response(new UserResource($user), 'Profile info');
    }

    public function updateProfile(UpdateUserRequest $request)
    {
        dd(Auth::user());
        $teacher = Auth::user();

        if (!$teacher) {
            return error_response([], 'Teacher not found', 404);
        }

        $validated = $request->validated();

        $profilePhotoPath = $teacher->profile_photo;

        if ($request->hasFile('profile_photo')) {
            $profilePhoto = $request->file('profile_photo');
            if ($profilePhoto->isValid()) {
                $profilePhotoName = uniqid('profile_', true) . '.' . $profilePhoto->getClientOriginalExtension();
                $profilePhotoPath = $profilePhoto->storeAs('profile_photos', $profilePhotoName, 'public'); // Faylni saqlash
            }
        }

        $teacher->update([
            'first_name' => $validated['first_name'] ?? $teacher->first_name,
            'last_name' => $validated['last_name'] ?? $teacher->last_name,
            'pinfl' => $validated['pinfl'] ?? $teacher->pinfl,
            'email' => $validated['email'] ?? $teacher->email,
            'password' => !empty($validated['password']) ? bcrypt($validated['password']) : $teacher->password,
            'profile_photo' => $profilePhotoPath,  // Yangi rasm yo'lini saqlash
        ]);

        return success_response(new UserResource($teacher), 'Teacher profile updated successfully');
    }
}
