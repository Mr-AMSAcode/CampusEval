<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'name' => "$firstName $lastName",
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'matricule' => $this->generateMatricule(),
            'role' => 'student',
            'is_active' => true,
            'phone' => fake()->optional()->phoneNumber(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Marquer l'email comme non vérifié
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Créer un utilisateur avec le rôle d'étudiant
     */
    public function student(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'student',
            'matricule' =>
                fake()->randomElement(['GL', 'SR'])
                . '.CMRY'
                . fake()->unique()->numberBetween(10, 99)
                . '.'
                . date('y')
                . '.'
                . strtoupper(Str::random(1)),
        ]);
    }


    /**
     * Créer un utilisateur avec le rôle d'enseignant
     */
    public function teacher(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'teacher',
            'matricule' => 'PER.CMR.'
                . fake()->unique()->numberBetween(1000, 9999)
                . '.CDI',
        ]);
    }

    /**
     * Créer un utilisateur avec le rôle de personnel
     */
    public function staff(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'staff',
            'matricule' => 'PER.CMR.'
                . fake()->unique()->numberBetween(1000, 9999)
                . '.CDI',
        ]);
    }
    /**
     * Créer un utilisateur avec le rôle de super admin
     */
    public function superAdmin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'super_admin',
            'email' => 'admin@campuseval.com',
            'password' => Hash::make('password'),
        ]);
    }

    /**
     * Générer un matricule valide
     */
    private function generateMatricule(): string
    {
        $prefix = fake()->randomElement(['GL', 'SR']);
        $year = date('y');
        $code = fake()->bothify('CMR##');
        $suffix = strtoupper(Str::random(1));
        
        return "{$prefix}.{$code}{$year}.{$year}.{$suffix}";
    }
}
