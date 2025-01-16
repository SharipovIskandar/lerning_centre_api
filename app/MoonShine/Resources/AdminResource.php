<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;

use Illuminate\Contracts\Database\Eloquent\Builder;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Password;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<ManageUsersResource>
 */
class AdminResource extends ModelResource
{
    protected string $model = User::class;

    protected string $title = 'Admins';
    public function modifyQueryBuilder(Builder $builder): Builder
    {
        return $builder->whereHas('roles', function ($query) {
            $query->where('key', 'admin');
        });
    }
    protected function afterCreated($item): mixed
    {
        if ($item instanceof User) {
            $adminRole = Role::query()->where('key', 'admin')->first();
            if ($adminRole) {
                $item->roles()->attach($adminRole->id);
                return $item;
            }
        }
        return null;
    }
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
                Number::make('Pinfl')->sortable(),
                File::make('Profile photo')->sortable()->nullable(),
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
            Number::make('Pinfl')->sortable(),
            File::make('Profile photo')->sortable()->nullable(),
            Text::make('Email')->sortable(),
            Password::make('Password')->sortable(),
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
}
