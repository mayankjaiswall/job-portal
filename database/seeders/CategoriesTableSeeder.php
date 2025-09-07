<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categories = [
            ['name' => 'IT',        'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Finance',   'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Marketing', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sales',     'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'HR',        'status' => 1, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('categories')->insert($categories);
    }
}
