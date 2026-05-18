<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffFactory extends Factory
{
    protected $model = Staff::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->staff(),
            'department_id' => Department::factory(),
            'position' => fake()->jobTitle(),
            'responsibilities' => fake()->sentence(8),
            'hire_date' => fake()->dateTimeBetween('-10 years', 'now'),
            'status' => 'active',
            'total_evaluations' => fake()->numberBetween(0, 100),
            'average_rating' => fake()->randomFloat(2, 1, 5),
        ];
    }
}

