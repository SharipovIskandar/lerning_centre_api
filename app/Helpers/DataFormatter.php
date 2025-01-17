<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;

class DataFormatter
{
    /**
     * Yagona modelni formatlash
     *
     * @param Model $model
     * @param callable $callback
     * @return array
     */
    public static function formatOne(Model $model, callable $callback): array
    {
        return $callback($model);
    }

    /**
     * Ko'p modellarga nisbatan formatlash
     *
     * @param iterable $items
     * @param callable $callback
     * @return array
     */
    public static function formatMany(iterable $items, callable $callback): array
    {
        return collect($items)->map($callback)->toArray();
    }

    /**
     * TeacherCourse uchun umumiy format
     *
     * @param $teacherCourse
     * @return array
     */
    public static function formatTeacherCourse($teacherCourse): array
    {
        return [
            'id' => $teacherCourse->id,
            'fio' => $teacherCourse->teacher->first_name . ' ' . $teacherCourse->teacher->last_name,
            'course_name' => $teacherCourse->course->name,
            'creted_at' => $teacherCourse->created_at,
            'updated_at' => $teacherCourse->updated_at,
        ];
    }
}
