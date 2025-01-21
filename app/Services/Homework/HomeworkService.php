<?php

namespace App\Services\Homework;

use App\Models\Homework;
use App\Services\Homework\Contracts\iHomeworkService;
use App\Traits\Crud;
use App\Http\Requests\HomeworkRequest;

class HomeworkService implements iHomeworkService
{
    use Crud;

    protected string $modelClass = Homework::class;

    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->modelClass::all();
    }

    public function show($id)
    {
        return $this->cEdit($id);
    }

    public function store(HomeworkRequest $request)
    {
        return $this->cStore($request);
    }

    public function update(HomeworkRequest $request, $id)
    {
        return $this->cUpdate($request, $id);
    }

    public function destroy($id)
    {
        return $this->cDelete($id);
    }
}
