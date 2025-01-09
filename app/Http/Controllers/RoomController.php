<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use App\Traits\Crud;

class RoomController extends Controller
{
    use Crud;
    protected string $modelClass = Room::class;

    public function index(): \Illuminate\Http\JsonResponse
    {
        $rooms = $this->modelClass::all();
        return success_response(RoomResource::collection($rooms), __('validation.rooms_found'));
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $room = $this->cEdit($id);
        return success_response(new RoomResource($room), __('validation.room_details'));
    }

    public function store(RoomRequest $request): \Illuminate\Http\JsonResponse
    {
        $room = $this->cStore($request);
        return success_response(new RoomResource($room), __('validation.room_created'));
    }

    public function update(RoomRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        $room = $this->cUpdate($request, $id);
        return success_response(new RoomResource($room), __('validation.room_updated'));
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $room = $this->cDelete($id);
        return success_response(new RoomResource($room), __('validation.room_deleted'));
    }
}
