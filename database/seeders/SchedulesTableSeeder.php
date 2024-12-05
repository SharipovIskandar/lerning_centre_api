<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schedule::create(['date' => '2024-12-10', 'time' => '10:00:00', 'room_id' => 1, 'course_id' => 1, 'teacher_id' => 1]);
        Schedule::create(['date' => '2024-12-11', 'time' => '14:00:00', 'room_id' => 2, 'course_id' => 2, 'teacher_id' => 2]);
    }
}
