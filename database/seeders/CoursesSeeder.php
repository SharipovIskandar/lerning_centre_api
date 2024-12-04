<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesSeeder extends Seeder
{
    public function run()
    {
        DB::table('courses')->insert([
            [
                'name' => 'Mathematics 101',
                'subject' => 'Mathematics',
                'description' => 'Basic algebra and geometry course.'
            ],
            [
                'name' => 'Computer Science 101',
                'subject' => 'Computer Science',
                'description' => 'Introduction to computer programming and algorithms.'
            ],
            [
                'name' => 'Physics 101',
                'subject' => 'Physics',
                'description' => 'Fundamentals of physics, mechanics and thermodynamics.'
            ],
            [
                'name' => 'History 101',
                'subject' => 'History',
                'description' => 'World history overview from ancient to modern times.'
            ],
            [
                'name' => 'Literature 101',
                'subject' => 'Literature',
                'description' => 'Introduction to classical and modern literature.'
            ],
        ]);
    }
}
