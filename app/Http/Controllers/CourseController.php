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
        return success_response(new CourseResource($course), __('messages.course_details'));
    }

    public function store(CourseRequest $request)
    {
        $course = new Course();
        $course->name = json_encode($request->name);
        $course->subject = $request->subject;
        $course->description = $request->description;
        $course->save();
        $this->attachTranslates($course, $request);

        return success_response(new CourseResource($course), __('messages.course_created'));
    }


    public function update(CourseRequest $request, $id)
    {
        $course = $this->cUpdate($request, $id);
        $this->attachTranslates($course, $request);
        return success_response(new CourseResource($course), __('messages.course_updated'));
    }

    public function destroy($id)
    {
        $course = $this->cDelete($id);
        return success_response(new CourseResource($course), __('messages.course_deleted'));
    }
}
