<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use App\Models\ClassModel;
use App\Models\Teacher;
use App\Models\Staff;
use App\Models\Student;
use App\Models\Evaluation;
use App\Models\EvaluationCriteria;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ===== Departments + Classes =====
        $departments = \App\Models\Department::factory()->count(3)->create(['is_active' => true]);
        $classes = \App\Models\ClassModel::factory()->count(6)->state(fn () => [
            'department_id' => $departments->random()->id,
        ])->create();

        // ===== Super admin =====
        $superAdmin = User::create([
            'first_name' => 'Amang',
            'last_name' => 'Said',
            'name' => 'AMSA',
            'email' => 'amsa@gmail.com',
            'matricule' => 'GL.CMR.2025.CDI',
            'password' => Hash::make('amsa1234@#'),
            'role' => 'super_admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $this->command->info('Super admin créé :');
        $this->command->info('  Email  : amsa@gmail.com');
        $this->command->info('  Mot de passe : amsa1234@#');
        $this->command->info('  Rôle   : super_admin');
        $this->command->info('  Matricule: GL.CMR.2025.CDI');

        // ===== Teachers + teacher_class pivot =====
        $teachers = \App\Models\Teacher::factory()->count(5)->state(fn () => [
            'department_id' => $departments->random()->id,
        ])->create();

        foreach ($teachers as $teacher) {
            $assignedClasses = $classes->random(fake()->numberBetween(1, 3));
            foreach ($assignedClasses as $class) {
                $teacher->classes()->attach($class->id, [
                    'subject' => fake()->word(),
                    'hours_per_week' => fake()->numberBetween(2, 8),
                    'start_date' => now()->subYear()->toDateString(),
                    'end_date' => null,
                    'status' => 'active',
                ]);
            }
        }

        // ===== Staff =====
        $staff = \App\Models\Staff::factory()->count(4)->state(fn () => [
            'department_id' => $departments->random()->id,
        ])->create();

        // ===== Students =====
        \App\Models\Student::factory()->count(12)->state(function () use ($classes) {
            $class = $classes->random();

            return [
                'class_id' => $class->id,
                'department_id' => $class->department_id,
            ];
        })->create();

        // ===== Evaluation criteria =====
        \App\Models\EvaluationCriteria::factory()->count(10)->create();

        // ===== Evaluations =====
        $evaluationTargets = $teachers->concat($staff);
        $students = Student::all();
        $created = 0;
        $attempts = 0;

        while ($created < 15 && $attempts < 100) {
            $attempts++;
            $student = $students->random();
            $evaluatable = $evaluationTargets->random();
            $type = get_class($evaluatable);

            if (Evaluation::where('student_id', $student->id)
                ->where('evaluatable_type', $type)
                ->where('evaluatable_id', $evaluatable->id)
                ->exists()) {
                continue;
            }

            Evaluation::factory()->withDetails()->create([
                'student_id' => $student->id,
                'evaluatable_type' => $type,
                'evaluatable_id' => $evaluatable->id,
            ]);

            $created++;
        }

    }
}
