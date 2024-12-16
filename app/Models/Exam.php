<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'duration',
        'total_marks',
        'course_id',
        'teacher_id',
        'classroom'
    ];

    /**
     * The course that owns the exam.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * The teacher that owns the exam.
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * The exam results for this exam.
     */
    public function results()
    {
        return $this->hasMany(ExamResult::class);
    }
}
