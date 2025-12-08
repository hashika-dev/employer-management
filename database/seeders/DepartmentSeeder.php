<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Define the Data Payload (Slug Removed)
        $departments = [
            [
                'name' => 'Engineering & Development',
                'description' => 'Responsible for backend, frontend, DevOps, and QA.',
            ],
            [
                'name' => 'Product Management & Design',
                'description' => 'Handles product roadmap, UI/UX design, and user research.',
            ],
            [
                'name' => 'Marketing',
                'description' => 'Focuses on demand generation, brand awareness, and growth hacking.',
            ],
            [
                'name' => 'Sales & Business Development',
                'description' => 'Manages inbound/outbound sales, partnerships, and revenue pipeline.',
            ],
            [
                'name' => 'Customer Success & Support',
                'description' => 'Ensures onboarding, technical support, and client retention.',
            ],
            [
                'name' => 'Operations & People',
                'description' => 'Oversees HR, finance, legal compliance, and office management.',
            ],
        ];

        // 2. Capture Current Time
        $now = Carbon::now();

        // 3. Iterate and Insert
        foreach ($departments as $department) {
            DB::table('departments')->insert([
                'name'        => $department['name'],
                'description' => $department['description'],
                // Slug line deleted here
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }
    }
}