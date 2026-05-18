<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassModelFactory extends Factory
{
    protected $model = \App\Models\ClassModel::class;

    public function definition(): array
    {
        $level = fake()->randomElement(['L1', 'L2', 'L3', 'M1', 'M2']);

        return [
            'name' => fake()->unique()->word() . " $level",
            'code' => fake()->unique()->bothify('CLASS##'),
            'department_id' => Department::factory(),
            'level' => $level,
            'student_count' => fake()->numberBetween(20, 100),
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
