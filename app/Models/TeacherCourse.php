<?php

namespace App\Models;

use App\Traits\Crud;
use App\Traits\HasFile;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherCourse extends Model
{
    use  Crud, HasTranslations;

    protected $fillable = ['teacher_id', 'course_id'];


}
