<?php

namespace App\Services\Homework\Contracts;

use App\Http\Requests\HomeworkEvaluationRequest;

interface iHomeworkEvaluationService
{
    public function index();
    public function show($id);
    public function store(HomeworkEvaluationRequest $request);
    public function update(HomeworkEvaluationRequest $request, $id);
    public function destroy($id);
}

