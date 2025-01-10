<?php

namespace App\Models;

use App\Traits\Crud;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use Crud, HasTranslations;

    public $fillable = ['name', 'description', 'subject'];
    public $translatable = ['name', 'description', 'subject'];
    public function students()
    {
        return $this->belongsToMany(User::class, 'course_students', 'course_id', 'student_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'course_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teachers_courses', 'course_id', 'teacher_id');
    }

}
