<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Role::create([
            'name' => 'Admin',
            'key' => 'admin',
        ]);

        Role::create([
            'name' => 'Student',
            'key' => 'student',
        ]);

        Role::create([
            'name' => 'Teacher',
            'key' => 'teacher',
        ]);
    }
}
