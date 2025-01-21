<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomeworkEvaluationRequest;
use App\Http\Resources\HomeworkEvaluationResource;
use App\Services\Homework\Contracts\iHomeworkEvaluationService;

class HomeworkEvaluationController extends Controller
{
    protected iHomeworkEvaluationService $homeworkEvaluationService;

    public function __construct(iHomeworkEvaluationService $homeworkEvaluationService)
    {
        $this->homeworkEvaluationService = $homeworkEvaluationService;
    }

    public function index()
    {
        $evaluations = $this->homeworkEvaluationService->index();
        return success_response(HomeworkEvaluationResource::collection($evaluations), 'Evaluations fetched successfully');
    }

    public function store(HomeworkEvaluationRequest $request)
    {
        $evaluation = $this->homeworkEvaluationService->store($request);
        return success_response(new HomeworkEvaluationResource($evaluation), 'Evaluation created successfully');
    }

    public function show($id)
    {
        $evaluation = $this->homeworkEvaluationService->show($id);
        return success_response(new HomeworkEvaluationResource($evaluation), 'Evaluation fetched successfully');
    }

    public function update(HomeworkEvaluationRequest $request, $id)
    {
        $evaluation = $this->homeworkEvaluationService->update($request, $id);
        return success_response(new HomeworkEvaluationResource($evaluation), 'Evaluation updated successfully');
    }

    public function destroy($id)
    {
        $this->homeworkEvaluationService->destroy($id);
        return success_response(null, 'Evaluation deleted successfully');
    }
}
