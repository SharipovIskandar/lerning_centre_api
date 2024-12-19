<?php

namespace App\Traits;

use Illuminate\Support\Facades\Schema;

trait Scopes
{
    public function scopeWhereEqual($query, $tableField, $requestField = null, $request = null): void
    {
        $request = getRequest($request);
        $requestField = $requestField ?? $tableField;
        if (!in_array($request->$requestField, [null, 'undefined']))
            $query->where($tableField, $request->$requestField);
    }

    public function scopeWhereLike($query, $tableField, $requestField = null, $request = null): void
    {
        $request = getRequest($request);
        $requestField = $requestField ?? $tableField;
        if (!in_array($request->$requestField, [null, 'undefined']))
            $query->where($tableField, 'ilike', '%' . $request->$requestField . '%');
    }

    public function scopeOrWhereLike($query, $tableField, $requestField = null, $request = null): void
    {
        $request = getRequest($request);
        $requestField = $requestField ?? $tableField;
        if (!in_array($request->$requestField, [null, 'undefined']))
            $query->orWhere($tableField, 'ilike', '%' . $request->$requestField . '%');
    }

    public function scopeWhereHasLike($query, $relationName, $tableField, $requestField = null, $request = null): void
    {
        $request = getRequest($request);
        $requestField = $requestField ?? $tableField;
        if (!in_array($request->$requestField, [null, 'undefined']))
            $query->whereHas($relationName, function ($query) use ($tableField, $requestField, $request) {
                $query->where($tableField, 'ilike', '%' . $request->$requestField . '%');
            });
    }

    public function scopeWhereHasEqual($query, $relationName, $tableField, $requestField = null, $request = null): void
    {
        $request = getRequest($request);
        $requestField = $requestField ?? $tableField;
        if (!in_array($request->$requestField, [null, 'undefined']))
            $query->whereHas($relationName, function ($query) use ($tableField, $requestField, $request) {
                $query->where($tableField, $request->$requestField);
            });
    }

    public function scopeOrWhereHasLike($query, $relationName, $tableField, $requestField = null, $request = null): void
    {
        $request = getRequest($request);
        $requestField = $requestField ?? $tableField;
        if (!in_array($request->$requestField, [null, 'undefined']))
            $query->orWhereHas($relationName, function ($query) use ($tableField, $requestField, $request) {
                $query->where($tableField, 'ilike', '%' . $request->$requestField . '%');
            });
    }

    public function scopeWhereBetween2($query, $tableField, $requestField = null, $request = null): void
    {
        $request = getRequest($request);
        $requestField = $requestField ?? $tableField;

        $start = $requestField . '_start';
        $end = $requestField . '_end';
        if ($request->$start) {
            $query->whereDate($tableField, '>=', $request->$start);
        }
        if ($request->$end) {
            $query->whereDate($tableField, '<=', $request->$end);
        }
    }

    public function scopeWhereBetween3($query, $tableField, $request = null): void
    {
        $request = getRequest($request);
        $start = $tableField . '_start';
        $end = $tableField . '_end';
        if ($request->$start) {
            $query->where($tableField, '>=', $request->$start);
        }
        if ($request->$end) {
            $query->where($tableField, '<=', $request->$end);
        }
    }

    public function scopeWhereEqualJson($query, $column, $field, $requestField = null, $request = null)
    {
        $request = getRequest($request);
        $requestField = $requestField ?: $field;
        if ($request->{$requestField}) {
            $query->whereRaw("$column::jsonb @> ?", [json_encode([$field => $request->{$requestField}])]);
        }
    }

    public function scopeWhereSearchJson($query, string $column, array $fields, $request = null)
    {
        $request = getRequest($request);
        $search = $request->search;
        if ($search) {
            $query->where(function ($query) use ($fields, $search, $column) {
                foreach ($fields as $index => $field) {
                    $index == 0
                        ? $query->whereRaw("{$column}::jsonb ->> ? ilike ?", [$field, "%{$search}%"])
                        : $query->orWhereRaw("{$column}::jsonb ->> ? ilike ?", [$field, "%{$search}%"]);
                }
            });
        }
    }

    public function scopeSort($query, $field = null, $direction = 'desc'): void
    {
        $sort = $field
            ? [
                'key' => $field,
                'value' => $direction
            ]
            : null;

        $order = $sort ?: requestOrder();
        $query->orderBy($order['key'] == 'id' ? $this->getTable() . '.id' : $order['key'], $order['value']);
    }

    public function scopeWhereSearch($query, $fieldNames, $request = null, $deepSearch = false)
    {
        $request = getRequest($request);
        $search = $request->get('search');

        if ($search) {
            $query->where(function ($query) use ($fieldNames, $search) {
                foreach ($fieldNames as $index => $field) {
                    $index == 0
                        ? $query->where($field, 'ilike', '%' . $search . '%')
                        : $query->orWhere($field, 'ilike', '%' . $search . '%');
                }
            });

            $query->when(Schema::hasColumns($this->getTable(), ['surname', 'name', 'patronymic']), function ($query) use ($search) {
                $query->orWhere(function ($query) use ($search) {
                    $query->whereRaw("CONCAT(surname, ' ', name, ' ', patronymic) ilike ?", ["%" . $search . "%"]);
                });
            });

            if ($this->translatable) {
                $query->orWhereHas('translations', function ($query) use ($fieldNames, $search, $deepSearch) {
                    $query->where(function ($query) use ($fieldNames, $search, $deepSearch) {
                        foreach ($fieldNames as $key => $field) {
                            $key == 0
                                ?   $query->where(function ($query) use ($field, $search, $deepSearch) {
                                    $query->where('field_name', $field)
                                        ->when(!$deepSearch, function ($query) {
                                            $query->where('language_url', app()->getLocale());
                                        })
                                        ->where('field_value', 'ilike',  '%' . $search . '%');
                                })
                                :   $query->orWhere(function ($query) use ($field, $search, $deepSearch) {
                                    $query->where('field_name', $field)
                                        ->when(!$deepSearch, function ($query) {
                                            $query->where('language_url', app()->getLocale());
                                        })
                                        ->where('field_value', 'ilike', '%' . $search . '%');
                                });
                        }
                    });
                });
            }
        }
    }

    public function scopeWhereHasSearch($query, $relation, $fieldNames, $request = null)
    {
        $request = getRequest($request);
        if($request->search) {
            $query->whereHas($relation, function ($query) use ($fieldNames, $request) {
                $query->whereSearch($fieldNames, $request);
            });
        }
    }

    public function scopeCustomPaginate($query, $per_page = null, $requestField = 'per_page', $request = null)
    {
        $request = getRequest($request);
        return $query->paginate($request->get($requestField, $per_page ?? self::count()));
    }
}
