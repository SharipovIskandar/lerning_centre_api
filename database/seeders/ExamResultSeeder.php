<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('exam_results')->insert([
            [
                'exam_id' => 1,
                'user_id' => 2,
                'score' => 45,
                'passed' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'exam_id' => 2,
                'user_id' => 2,
                'score' => 50,
                'passed' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
