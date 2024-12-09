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
            'name' => 'admin',
            'key' => 'admin',
        ]);

        Role::create([
            'name' => 'student',
            'key' => 'student',
        ]);

        Role::create([
            'name' => 'teacher',
            'key' => 'teacher',
        ]);
    }
}
