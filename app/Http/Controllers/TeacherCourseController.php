<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherCourseRequest;
use App\Http\Resources\TeacherCourseResource;
use App\Models\TeacherCourse;
use App\Traits\Crud;
use Illuminate\Http\JsonResponse;

class TeacherCourseController extends Controller
{
    use Crud;

    protected string $modelClass = TeacherCourse::class;

    public function index(): JsonResponse
    {
        $teacherCourses = TeacherCourse::with(['teacher', 'course'])->get();
        return success_response(
            TeacherCourseResource::collection($teacherCourses),
            __("messages.retrieved")
        );
    }


    public function store(TeacherCourseRequest $request): JsonResponse
    {
        $teacherCourse = $this->cStore($request);

        return success_response(new TeacherCourseResource($teacherCourse), __('messages.teacher_course_created'), 201);
    }

    public function edit($id): JsonResponse
    {
        $teacherCourse = $this->cEdit($id);

        return success_response(new TeacherCourseResource($teacherCourse), null, 200);
    }

    public function update(TeacherCourseRequest $request, $id): JsonResponse
    {
        $teacherCourse = $this->cUpdate($request, $id);

        return success_response(new TeacherCourseResource($teacherCourse), __('messages.teacher_course_updated'), 200);
    }

    public function destroy($id): JsonResponse
    {
        $this->cDelete($id);

        return success_response(null, __('messages.teacher_course_deleted'), 200);
    }
}
