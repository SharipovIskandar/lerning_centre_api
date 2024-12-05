<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseStudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('course_students')->insert([
            ['course_id' => 1, 'student_id' => 1],
            ['course_id' => 1, 'student_id' => 2],
            ['course_id' => 2, 'student_id' => 3],
        ]);
    }
}
