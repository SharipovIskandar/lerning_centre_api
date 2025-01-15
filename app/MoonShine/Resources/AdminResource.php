<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Http\Resources\UserResource;
use App\Models\User;

use App\Models\UserRole;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;

/**
 * @extends ModelResource<UserResource>
 */
class AdminResource extends ModelResource
{
    protected string $model = User::class;

    protected string $title = 'Admins';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
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
     * @param Admin $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
    protected function filters(): array
    {
        return [
            Select::make('Role', 'role_id')
                ->options(function () {
                    return UserRole::query()->whereHas('user', function ($query) {
                        $query->students();
                    })->pluck('role_id', 'role_id')->toArray();
                })
                ->filter(function ($query, $value) {
                    return $query->whereHas('roles', function ($query) use ($value) {
                        $query->where('role_id', $value);
                    });
                }),
        ];
    }

}
