<?php

namespace App\Http\Controllers;

use App\Models\ExamResult;
use App\Http\Resources\ExamResultResource;
use Illuminate\Http\Request;

class ExamResultController extends Controller
{
    public function index()
    {
        $examResults = ExamResult::with(['exam', 'user'])->get();
        return success_response(ExamResultResource::collection($examResults), __('examResult.fetch_success'));
    }

    public function show($id)
    {
        $examResult = ExamResult::find($id);

        if (!$examResult) {
            return error_response(null, __('examResult.fetch_not_found'), 404);
        }

        return success_response(new ExamResultResource($examResult), __('examResult.fetch_success'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'user_id' => 'required|exists:users,id',
            'score' => 'required|integer',
            'passed' => 'required|boolean',
        ]);

        $examResult = ExamResult::create($request->all());

        return success_response(new ExamResultResource($examResult), __('examResult.create_success'), 201);
    }

    public function update(Request $request, $id)
    {
        $examResult = ExamResult::find($id);

        if (!$examResult) {
            return error_response(null, __('examResult.fetch_not_found'), 404);
        }

        $request->validate([
            'score' => 'required|integer',
            'passed' => 'required|boolean',
        ]);

        $examResult->update($request->all());

        return success_response(new ExamResultResource($examResult), __('examResult.update_success'));
    }

    public function destroy($id)
    {
        $examResult = ExamResult::find($id);

        if (!$examResult) {
            return error_response(null, __('examResult.fetch_not_found'), 404);
        }

        $examResult->delete();

        return success_response(null, __('examResult.delete_success'));
    }
}
