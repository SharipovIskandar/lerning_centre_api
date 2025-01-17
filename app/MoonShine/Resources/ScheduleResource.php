<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Room;
use App\Models\Schedule;

use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Schedule>
 */
class ScheduleResource extends ModelResource
{
    protected string $model = Schedule::class;

    protected string $title = 'Schedules';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Date::make('Date')->sortable(),
            Text::make('Time')->sortable(),
            BelongsTo::make('Room', 'room',
                formatted: fn($iteam) => $iteam->name,
                resource: RoomResource::class),
            BelongsTo::make('Courses', 'course',
                formatted: fn($iteam) => $iteam->name,
                resource: CourseResource::class),
            BelongsTo::make('Teacher', 'teacher',
                formatted: fn($iteam) => $iteam->first_name,
                resource: TeacherResource::class),
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make()->sortable(),
                Date::make('Date')->sortable(),
                Text::make('Time', 'time')
                    ->default(now()->format('H:i:s'))
                    ->sortable(),
                BelongsTo::make('Room', 'room',
                    formatted: fn($iteam) => $iteam->name,
                    resource: RoomResource::class),
                BelongsTo::make('Courses', 'course',
                    formatted: fn($iteam) => $iteam->name,
                    resource: CourseResource::class),
                BelongsTo::make('Teacher', 'teacher',
                    formatted: fn($iteam) => $iteam->first_name,
                    resource: TeacherResource::class),
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
        ];
    }

    /**
     * @param Schedule $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
