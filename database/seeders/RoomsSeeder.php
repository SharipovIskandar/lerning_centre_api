<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomsSeeder extends Seeder
{
    public function run()
    {
        DB::table('rooms')->insert([
            ['name' => 'Room 101'],
            ['name' => 'Room 102'],
            ['name' => 'Room 103'],
            ['name' => 'Room 104'],
            ['name' => 'Room 105'],
            ['name' => 'Room 106'],
            ['name' => 'Room 107'],
            ['name' => 'Room 108'],
            ['name' => 'Room 109'],
            ['name' => 'Room 110'],
        ]);
    }
}
