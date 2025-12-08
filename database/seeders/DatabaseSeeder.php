<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Test User creation (Must be updated to match the new name structure)
        User::factory()->create([
            'first_name' => 'Test',
            'last_name'  => 'User',
            'email'      => 'test@example.com',
            'role'       => 'user', // Ensure a default role is set
        ]);
        
        // 2. Call your other seeders
        $this->call([
            // DepartmentSeeder MUST run first to create the departments.
            DepartmentSeeder::class,
            
            // This seeds the 6-9 random Filipino employees per department.
            EmployeeDepartmentSeeder::class,
            
            // If you have other specific users defined in UserSeeder (like 'Thomas Anderson'), uncomment this:
            // UserSeeder::class,
        ]);
    }
}