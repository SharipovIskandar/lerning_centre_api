<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\User;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Password;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<User>
 */
class ManageUsersResource extends ModelResource
{
    protected string $model = User::class;

    protected string $title = 'ManageUsers';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('First name')->sortable(),
            Text::make('Last name')->sortable(),
            Text::make('Email')->sortable(),
            Password::make('Password')->sortable(),
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
                Text::make('First name')->sortable(),
                Text::make('Last name')->sortable(),
                Text::make('Email')->sortable(),
                Password::make('Password')->sortable(),
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
            Text::make('First name')->sortable(),
            Text::make('Last name')->sortable(),
            Text::make('Email')->sortable(),
            Password::make('Password')->sortable(),
        ];
    }

    /**
     * @param User $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }

}
