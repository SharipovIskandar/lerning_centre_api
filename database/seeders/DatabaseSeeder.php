<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->count(10)->create();
        $this->call([
            RoomsSeeder::class,
            RoleSeeder::class,
            CoursesSeeder::class,
            SchedulesTableSeeder::class,
            CourseStudentsTableSeeder::class,
            UserRolesTableSeeder::class,
            TeachersCoursesTableSeeder::class
        ]);
    }
}
