<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\ExamResult;

use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Boolean;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<ExamResult>
 */
class ExamResultResource extends ModelResource
{
    protected string $model = ExamResult::class;

    protected string $title = 'ExamResults';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Exam', 'exam',
                formatted: fn($iteam) => $iteam->title,
                resource: ExamResultResource::class),
            BelongsTo::make('Student', 'user',
                formatted: fn($iteam) => $iteam->first_name,
                resource: StudentResource::class),
            Number::make('Score')->sortable(),
            Text::make('Passed')
                ->sortable(),
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
                BelongsTo::make('Exam', 'exam',
                    formatted: fn($iteam) => $iteam->title,
                    resource: ExamResultResource::class),
                BelongsTo::make('Student', 'user',
                    formatted: fn($iteam) => $iteam->first_name,
                    resource: StudentResource::class),
                Number::make('Score')->sortable(),
                Text::make('Passed')
                    ->sortable(),
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Exam', 'exam',
                formatted: fn($iteam) => $iteam->title,
                resource: ExamResultResource::class),
            BelongsTo::make('Student', 'user',
                formatted: fn($iteam) => $iteam->first_name,
                resource: StudentResource::class),
            Number::make('Score')->sortable(),
            Text::make('Passed')
                ->sortable(),
        ];
    }

    /**
     * @param ExamResult $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
