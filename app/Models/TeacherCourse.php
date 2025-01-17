<?php

namespace App\Models;

use App\Traits\Crud;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class TeacherCourse extends Model
{
    use  Crud, HasTranslations;

    protected $fillable = ['teacher_id', 'course_id'];

    public function teacher()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

}
