<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\ClassModel;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->student(),
            'class_id' => ClassModel::factory(),
            'department_id' => Department::factory(),
            'student_number' => fake()->unique()->numerify('STU########'),
            'enrollment_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'status' => 'active',
            'evaluations_count' => fake()->numberBetween(0, 20),
        ];
    }
}
