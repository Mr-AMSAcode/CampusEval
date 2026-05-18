<?php

namespace Database\Factories;

use App\Models\Evaluation;
use App\Models\EvaluationCriteria;
use App\Models\Staff;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class EvaluationFactory extends Factory
{
    protected $model = Evaluation::class;

    public function definition(): array
    {
        $student = Student::query()->inRandomOrder()->first();

        [$evaluatableType, $evaluatable] = $this->findAvailableEvaluatableForStudent($student);

        return [
            'student_id' => $student->id,
            'evaluatable_type' => $evaluatableType,
            'evaluatable_id' => $evaluatable->id,
            'rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->optional()->sentence(12),
            'is_anonymous' => true,
            'anonymized_hash' => null,
            'anonymous_until' => null,
            'status' => fake()->randomElement([
                'pending',
                'published',
            ]),
            'shows_student_identity' => false,
            'reviewed_at' => null,
            'reviewed_by_id' => null,
        ];
    }

    protected function findAvailableEvaluatableForStudent(Student $student): array
    {
        $types = [Teacher::class, Staff::class];
        shuffle($types);

        foreach ($types as $type) {
            $evaluatable = $type::query()
                ->whereDoesntHave('evaluations', function ($query) use ($student) {
                    $query->where('student_id', $student->id);
                })
                ->inRandomOrder()
                ->first();

            if ($evaluatable) {
                return [$type, $evaluatable];
            }
        }

        // Si toutes les cibles sont déjà évaluées par cet étudiant, choisir une autre paire aléatoire.
        $type = fake()->randomElement($types);
        $evaluatable = $type::query()->inRandomOrder()->first();

        return [$type, $evaluatable];
    }

    /**
     * Attach random criteria scores after creation.
     */
    public function withDetails(): self
    {
        return $this->afterCreating(function (Evaluation $evaluation) {
            $type = $evaluation->evaluatable_type === Teacher::class ? 'teacher' : 'staff';

            $criteria = EvaluationCriteria::query()
                ->where('type', $type)
                ->inRandomOrder()
                ->limit(5)
                ->get();

            foreach ($criteria as $criterion) {
                $evaluation->details()->create([
                    'criterion_id' => $criterion->id,
                    'score' => fake()->numberBetween(1, 5),
                ]);
            }

            $evaluation->hideStudentIdentity();
        });
    }
}

