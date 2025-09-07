<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $jobTypes = [
            ['name' => 'Full Time',  'status' => 1,   'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Part Time',  'status' => 1,   'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Contract',   'status' => 1,   'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Internship', 'status' => 1,   'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Freelance',  'status' => 1,   'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('job_types')->insert($jobTypes);
    }
}
