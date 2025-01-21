<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseStudentRequest;
use App\Http\Resources\CourseStudentResource;
use App\Models\CourseStudent;
use App\Traits\Crud;

class CourseStudentController extends Controller
{
    use Crud;

    protected $modelClass = CourseStudent::class;

    public function index()
    {
        $courseStudents = CourseStudent::with(['user', 'course'])->get();

        return success_response(CourseStudentResource::collection($courseStudents), __('messages.retrieved'));
    }

    public function store(CourseStudentRequest $request)
    {
        $courseStudent = $this->cStore($request);
        return success_response($courseStudent, __('messages.stored successfully'), 201);
    }

    public function show($id)
    {
        $courseStudent = $this->cEdit($id);
        return success_response(new CourseStudentResource($courseStudent), __('messages.edited successfully'));
    }

    public function update(CourseStudentRequest $request, $id)
    {
        $courseStudent = $this->cUpdate($request, $id);
        return success_response($courseStudent, __('messages.updated successfully'), 200);
    }

    public function destroy($id)
    {
        $this->cDelete($id);
        return success_response(null, __('messages.deleted_successfully'));
    }
}
