<?php

namespace App\Traits;

use App\Models\Translation;
use Exception;
use Illuminate\Support\Collection;

trait HasTranslations
{
    public function getLocale(): string
    {
        return app()->getLocale();
    }

    public function getTranslationsAttribute(): Collection
    {
        return $this->translations()->get();
    }

    // barcha fieldlarni bitta tildagi tarjimalari
    public function getTranslationAttributes($locale = null)
    {
        return $this->translations->where('language_url', $locale ?: $this->getLocale());
    }

    // bitta fieldni barcha tillardagi tarjimasi
    public function translates($field)
    {
        if ($this->isAvailableField($field))
            return $this->translations->where('field_name', $field);
        throw new Exception("This field is not in translatables array: $field");
    }

    // bitta fieldni json formatda barcha tillardagi tarjimalarini olish
    public function pluckTranslates($field)
    {
        return $this->translates($field)->all() ? $this->translates($field)->pluck('field_value', 'language_url') : null;
    }

    // field bor yoki yo'qligini tekshirish
    protected function isAvailableField($field): bool
    {
        return in_array($field, $this->translatable);
    }

    // bitta fieldni bitta til bo'yicha tarjimasini save qilish
    public function setTranslation($field, $value, $locale = null)
    {
        $locale = $locale ?: $this->getLocale();

        if ($value) {
            Translation::updateOrCreate([
                'table_name' => $this->getTable(),
                'field_id' => $this->id,
                'field_name' => $field,
                'language_url' => $locale,
            ], [
                'field_value' => $value
            ]);

            if ($locale == config('app.fallback_locale')) {
                $this->update([
                    $field => $value
                ]);
            }
        }

        return $this;
    }

    public function setTranslations($field, $array)
    {
        if ($this->isAvailableField($field)) {
            foreach ($array as $locale => $value) {
                $this->setTranslation($field, $value, $locale);
            }
        }
        return $this;
    }

    // bir nechta field tarjimalarini bittada save qilish
    public function setTranslationsArray($array): static
    {
        foreach ($array as $field => $value) {
            $this->setTranslations($field, $value);
        }
        return $this;
    }

    public function translations()
    {
        return $this->hasMany(Translation::class, 'field_id', 'id')
            ->where('table_name', $this->getTable());
    }

    public function translate($field, $lang = null, bool $onlySelf = false)
    {
        return $this->translations
            ->where('field_name', $field)
            ->where('language_url', $lang ?: $this->getLocale())
            ->first()?->field_value ?: ($onlySelf ? null : $this->{$field});
    }

    public function deleteTranslations()
    {
        return $this->translations()->delete();
    }
}
