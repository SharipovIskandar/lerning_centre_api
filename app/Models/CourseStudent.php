<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseStudent extends Model
{

    use HasFactory;
    protected $fillable = ['course_id', 'student_id'];

    public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'id'); 
}

    public function course(){
        return $this->belongsTo(Course::class);
    }
}
