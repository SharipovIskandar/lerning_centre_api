<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamRequest;
use App\Http\Resources\ExamResource;
use App\Models\Exam;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::all();
        return success_response(ExamResource::collection($exams), __('messages.exam_list_retrieved'));
    }

    /**
     * Store a newly created exam in storage.
     */
    public function store(ExamRequest $request)
    {
        $exam = Exam::create($request->validated());
        return success_response(new ExamResource($exam), __('messages.exam_created'), 201);
    }

    /**
     * Update the specified exam in storage.
     */
    public function update(ExamRequest $request, Exam $exam)
    {
        $exam->update($request->validated());
        return success_response(new ExamResource($exam), __('messages.exam_updated'));
    }

    /**
     * Remove the specified exam from storage.
     */
    public function destroy(Exam $exam)
    {
        $exam->delete();
        return success_response(null, __('messages.exam_deleted'));
    }

    /**
     * Display the specified exam.
     */
    public function show(Exam $exam)
    {
        $response = Exam::query()->findOrFail($exam->id);
        return success_response(new ExamResource($response), __('messages.exam_retrieved'));
    }
}
