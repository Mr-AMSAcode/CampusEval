<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->teacher(),
            'department_id' => Department::factory(),
            'specialty' => fake()->word(),
            'qualifications' => fake()->sentence(),
            'hire_date' => fake()->dateTimeBetween('-10 years', 'now'),
            'status' => 'active',
            'total_evaluations' => fake()->numberBetween(0, 100),
            'average_rating' => fake()->randomFloat(2, 1, 5),
        ];
    }
}
