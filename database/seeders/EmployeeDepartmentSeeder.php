<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Seeder;

class EmployeeDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Computation: Fetch all Department IDs
        $departmentIds = Department::pluck('id')->all();

        // 2. Loop through the 6 departments
        foreach ($departmentIds as $departmentId) {
            
            // 3. Computation: Calculate the random number (6 to 9)
            $employeeCount = rand(6, 9); 
            echo "Seeding {$employeeCount} employees for Department ID: {$departmentId}\n";

            // 4. Factory Call & Linking
            // Create the users using the random Filipino names 
            // and explicitly link them to the current department ID.
            User::factory()->count($employeeCount)->create([
                'department_id' => $departmentId,
            ]);
        }
    }
}