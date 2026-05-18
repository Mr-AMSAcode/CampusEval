<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company() . ' Department',
            'code' => fake()->unique()->bothify('DEPT###'),
            'description' => fake()->sentence(),
            'head_name' => fake()->name(),
            'contact_email' => fake()->companyEmail(),
            'phone' => fake()->phoneNumber(),
            'student_count' => fake()->numberBetween(50, 500),
            'is_active' => true,
        ];
    }
}
