<?php

namespace App\Models;

use App\Traits\DataFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class   Schedule extends Model
{
    use HasFactory;
    protected $fillable = ['date', 'time', 'teacher_id', 'room_id', 'course_id'];
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function students()
    {
        return $this->belongsToMany(User::class, 'course_students', 'course_id', 'student_id');
    }

}
