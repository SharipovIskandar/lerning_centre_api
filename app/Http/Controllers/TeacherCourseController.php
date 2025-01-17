<?php

namespace App\Http\Controllers;

use App\Helpers\DataFormatter;
use App\Models\TeacherCourse;
use App\Http\Requests\TeacherCourseRequest;
use App\Traits\Crud;
use Illuminate\Http\JsonResponse;

class TeacherCourseController extends Controller
{
    use Crud;

    protected string $modelClass = TeacherCourse::class;

    public function index(TeacherCourseRequest $request): JsonResponse
    {
        $teacherCourses = TeacherCourse::all();
        $formattedCourses = DataFormatter::formatMany($teacherCourses, function (TeacherCourse $teacherCourse) {
            return DataFormatter::formatTeacherCourse($teacherCourse);
        });
        return success_response($formattedCourses, __("messages.retrieved"));
    }
    public function store(TeacherCourseRequest $request): JsonResponse
    {
        $teacherCourse = $this->cStore($request);
        $formattedCourses = DataFormatter::formatTeacherCourse($teacherCourse);
        return success_response($formattedCourses, __('messages.teacher_course_created'), 201);
    }

    public function edit($id): JsonResponse
    {
        $teacherCourse = $this->cEdit($id);
        $formattedCourse = DataFormatter::formatTeacherCourse($teacherCourse);
        return success_response($formattedCourse, null, 200);
    }


    public function update(TeacherCourseRequest $request, $id): JsonResponse
    {
        $teacherCourse = $this->cUpdate($request, $id);
        $formattedCourses = DataFormatter::formatTeacherCourse($teacherCourse);
        return success_response($formattedCourses, __('messages.teacher_course_updated'), 200);
    }

    public function destroy($id): JsonResponse
    {
        $this->cDelete($id);

        return success_response(null, __('messages.teacher_course_deleted'), 200);
    }
}
