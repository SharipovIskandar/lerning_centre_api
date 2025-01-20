<?php

namespace App\Http\Controllers;

use App\Models\CourseStudent;
use App\Http\Requests\CourseStudentRequest;
use App\Http\Resources\CourseStudentResource;
use App\Traits\Crud;
use Illuminate\Http\Request;

class CourseStudentController extends Controller
{
    use Crud;

    protected $modelClass = CourseStudent::class;

    public function index()
    {
        $courseStudents = CourseStudent::with(['user', 'course'])->get();

        return success_response(CourseStudentResource::collection($courseStudents), __('Course students retrieved successfully'));
    }

    public function store(CourseStudentRequest $request)
    {
        $courseStudent = $this->cStore($request);
        return success_response($courseStudent, __('Course student created successfully'), 201);
    }

    public function show($id)
    {
        $courseStudent = $this->cEdit($id);
        return success_response(new CourseStudentResource($courseStudent), __('Course student retrieved successfully'));
    }

    public function update(CourseStudentRequest $request, $id)
    {
        $courseStudent = $this->cUpdate($request, $id);
        return success_response($courseStudent, __('Course student updated successfully'));
    }

    public function destroy($id)
    {
        $this->cDelete($id);
        return success_response(null, __('Course student deleted successfully'));
    }
}
