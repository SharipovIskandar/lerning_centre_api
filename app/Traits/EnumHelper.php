<?php

namespace App\Traits;

use Illuminate\Support\Facades\Lang;

trait EnumHelper
{
    public static function values(): array
    {
        $values = [];
        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }
        return $values;
    }

    public static function in(bool $isValidation = true): string
    {
        $data = implode(',', self::values());
        if ($isValidation) {
            $data = 'in:' . $data;
        }
        return $data;
    }

    public static function list()
    {
        $list = [];
        foreach (self::values() as $value) {
            $list[$value] = Lang::has("enum.$value")
                ? __('enum.' . $value)
                : ucfirst($value);
        }
        return $list;
    }

    public static function translate($case, $locale = null)
    {
        return Lang::has("enum.$case", $locale)
            ? [
                'code' => $case,
                'name' => __('enum.' . $case, locale: $locale),
            ]
            : [
                'code' => $case,
                'name' => ucfirst($case)
            ];
    }
}
