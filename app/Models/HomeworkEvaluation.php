<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeworkEvaluation extends Model
{
    use HasFactory;
    protected $table = 'homework_evaluations';
    protected $fillable = ['homework_id', 'student_id', 'score', 'feedback'];

    public function homework()
    {
        return $this->belongsTo(Homework::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
