<?php

namespace Database\Factories;

use App\Models\EvaluationCriteria;
use Illuminate\Database\Eloquent\Factories\Factory;

class EvaluationCriteriaFactory extends Factory
{
    protected $model = EvaluationCriteria::class;

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(2),
            'description' => fake()->sentence(10),
            'type' => fake()->randomElement(['teacher', 'staff']),
            'weight' => fake()->numberBetween(1, 3),
            'order' => fake()->numberBetween(1, 10),
            'is_active' => true,
        ];
    }
}

