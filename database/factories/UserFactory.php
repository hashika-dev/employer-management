<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition(): array
{
    // --- START: CUSTOM FILIPINO NAMES ---
// Define a limited pool of common Filipino names for simulation
$filipinoFirstNames = ['Maria', 'Jose', 'Elena', 'Rafael', 'Diego', 'Carmela', 'Juan', 'Sofia', 'Renato', 'Luzviminda'];
$filipinoLastNames = ['Dela Cruz', 'Santos', 'Ramos', 'Garcia', 'Perez', 'Aquino', 'Reyes', 'Torres', 'Lozano', 'Cruz'];

$randomFirstName = $filipinoFirstNames[array_rand($filipinoFirstNames)];
$randomLastName = $filipinoLastNames[array_rand($filipinoLastNames)];

// --- END: CUSTOM FILIPINO NAMES ---

return [
    'first_name' => $randomFirstName,
    // Randomly include a middle initial 
    'middle_initial' => (rand(0, 1) === 1) ? strtoupper(fake()->randomLetter()) : null,
    'last_name' => $randomLastName,
    // Randomly include a suffix (Jr., Sr., III)
    'suffix_name' => (rand(0, 5) === 0) ? fake()->suffix() : null,
    
    'email' => fake()->unique()->safeEmail(),
    // Standard required fields
    'password' => \Illuminate\Support\Facades\Hash::make('password'),
    'role' => 'employee', // Default to employee role
    'email_verified_at' => now(),
    // ... (other fields)
];
}

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
