<?php

namespace App\Services\Homework;

use App\Models\HomeworkEvaluation;
use App\Services\Homework\Contracts\iHomeworkEvaluationService;
use App\Traits\Crud;
use App\Http\Requests\HomeworkEvaluationRequest;

class HomeworkEvaluationService implements iHomeworkEvaluationService
{
    use Crud;

    protected string $modelClass = HomeworkEvaluation::class;

    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->modelClass::all();
    }

    public function show($id)
    {
        return $this->cEdit($id);
    }

    public function store(HomeworkEvaluationRequest $request)
    {
        return $this->cStore($request);
    }

    public function update(HomeworkEvaluationRequest $request, $id)
    {
        return $this->cUpdate($request, $id);
    }

    public function destroy($id)
    {
        return $this->cDelete($id);
    }
}
