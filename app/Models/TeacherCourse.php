<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherCourse extends Model
{
    use HasFactory;

    protected $fillable = ['teacher_id', 'course_id'];


}
