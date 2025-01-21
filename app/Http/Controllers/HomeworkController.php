<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomeworkRequest;
use App\Http\Resources\HomeworkResource;
use App\Services\Homework\Contracts\iHomeworkService;

class HomeworkController extends Controller
{
    protected iHomeworkService $homeworkService;

    public function __construct(iHomeworkService $homeworkService)
    {
        $this->homeworkService = $homeworkService;
    }

    public function index()
    {
        $homeworks = $this->homeworkService->index();
        return success_response(HomeworkResource::collection($homeworks), 'Homeworks fetched successfully');
    }

    public function store(HomeworkRequest $request)
    {
        $homework = $this->homeworkService->store($request);
        return success_response(new HomeworkResource($homework), 'Homework created successfully');
    }

    public function show($id)
    {
        $homework = $this->homeworkService->show($id);
        return success_response(new HomeworkResource($homework), 'Homework fetched successfully');
    }

    public function update(HomeworkRequest $request, $id)
    {
        $homework = $this->homeworkService->update($request, $id);
        return success_response(new HomeworkResource($homework), 'Homework updated successfully');
    }

    public function destroy($id)
    {
        $this->homeworkService->destroy($id);
        return success_response(null, 'Homework deleted successfully');
    }
}
