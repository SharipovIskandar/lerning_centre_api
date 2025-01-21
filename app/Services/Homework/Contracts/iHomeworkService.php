<?php

namespace App\Services\Homework\Contracts;

use App\Http\Requests\HomeworkRequest;

interface iHomeworkService
{
    public function index();
    public function show($id);
    public function store(HomeworkRequest $request);
    public function update(HomeworkRequest $request, $id);
    public function destroy($id);
}
