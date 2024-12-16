<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exam;
use Illuminate\Support\Facades\DB;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Exam::create([
            'title' => 'Math Final Exam',
            'description' => 'This is the final exam for the Math course.',
            'date' => '2024-12-25',
            'duration' => '2 hours',
            'total_marks' => 100,
            'course_id' => 1,
            'teacher_id' => 1,
            'room_id' => 1,
        ]);

        Exam::create([
            'title' => 'Science Midterm Exam',
            'description' => 'This is the midterm exam for the Science course.',
            'date' => '2024-12-20',
            'duration' => '1.5 hours',
            'total_marks' => 80,
            'course_id' => 2,
            'teacher_id' => 2,
            'room_id' => 2,
        ]);
    }
}
