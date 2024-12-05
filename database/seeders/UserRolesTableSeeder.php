<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('user_roles')->insert([
            ['user_id' => 1, 'role_id' => 1, 'status' => true],
            ['user_id' => 2, 'role_id' => 2, 'status' => true],
            ['user_id' => 3, 'role_id' => 3, 'status' => true],
        ]);
    }
}
