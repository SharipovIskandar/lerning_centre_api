<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Traits\Crud;

class CourseController extends Controller
{
    use Crud;

    protected $modelClass = Course::class;

    public function index()
    {
        $courses = Course::all();
        return success_response(CourseResource::collection($courses), __('validation.courses_found'));
    }

    public function show($id)
    {
        $course = $this->cEdit($id);
        return success_response(new CourseResource($course), __('validation.course_details'));
    }

    public function store(CourseRequest $request)
    {
        $course = $this->cStore($request);
        return success_response(new CourseResource($course), __('validation.course_created'));
    }

    public function update(CourseRequest $request, $id)
    {
        $course = $this->cUpdate($request, $id);
        return success_response(new CourseResource($course), __('validation.course_updated'));
    }

    public function destroy($id)
    {
        $course = $this->cDelete($id);
        return success_response(new CourseResource($course), __('validation.course_deleted'));
    }
}
