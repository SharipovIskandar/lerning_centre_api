<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeachersCoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('teachers_courses')->insert([
            ['teacher_id' => 1, 'course_id' => 1],
            ['teacher_id' => 2, 'course_id' => 2],
        ]);
    }
}
