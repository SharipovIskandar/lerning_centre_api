<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Payment;

use Illuminate\Database\Eloquent\Model;
use MoonShine\Laravel\DependencyInjection\Request;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Payment>
 */
class PaymentResource extends ModelResource
{
    protected string $model = Payment::class;
    protected string $title = 'Payments';

    protected function beforeCreating(mixed $item): mixed
    {
        if ($item instanceof \App\Models\Payment) {
            $item->transaction_id = rand(10000, 99999);
        }
        return $item;
    }
    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make(
                'Email', 'user',
                formatted: fn($iteam) => "Full name: $iteam->last_name $iteam->first_name - $iteam->email",
                resource: StudentResource::class)->searchable(),
            Number::make('Amount', 'amount')->sortable(),
            Text::make('Status', 'status')->sortable(),
            Text::make('date', 'payment_date')->sortable(),
            Number::make('Transaction ID', 'transaction_id')->sortable(),
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
                BelongsTo::make(
                    'Email', 'user',
                    formatted: fn($iteam) => $iteam->email,
                    resource: StudentResource::class)
                    ->searchable(),
                Number::make('Amount', 'amount')->sortable(),
                Select::make('Status', 'status')->options([
                    'pending' => 'Pending',
                    'completed' => 'Completed',
                ]),
                Date::make('Payment Date')
                    ->format('Y-m-d H:i:s')
                    ->default(now()->toDateString()),
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
            BelongsTo::make('User id', 'user', resource: StudentResource::class)->searchable(),
            Number::make('Amount', 'amount')->sortable(),
            Text::make('Status', 'status')->sortable(),
            Text::make('date', 'payment_date')->sortable(),
            Text::make('Transaction ID', 'transaction_id')->sortable(),
        ];
    }

    /**
     * @param Payment $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
