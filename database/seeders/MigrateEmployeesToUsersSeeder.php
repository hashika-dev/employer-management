<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\User;

class MigrateEmployeesToUsersSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();
        $count = 0;

        foreach ($employees as $employee) {
            // Find the User that matches this Employee's email
            $user = User::where('email', $employee->email)->first();

            if ($user) {
                $user->update([
                    'job_title'       => $employee->job_title,
                    'phone'           => $employee->phone,
                    'department_id'   => $employee->department_id,
                    'gender'          => $employee->gender,
                    'birthday'        => $employee->birthday,
                    'address'         => $employee->address,
                    'emergency_name'  => $employee->emergency_name,
                    'emergency_phone' => $employee->emergency_phone,
                    'emergency_relation' => $employee->emergency_relation,
                    
                    // Mark as setup
                    'is_setup'        => 1, 
                    'profile_completed' => 1,
                ]);
                $count++;
            }
        }
        $this->command->info("Migrated {$count} employees to Users.");
    }
}