<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Teacher;

class TeacherPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Tous peuvent voir la liste des enseignants
    }

    public function view(User $user, Teacher $teacher): bool
    {
        return true; // Tous peuvent voir un enseignant
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function update(User $user, Teacher $teacher): bool
    {
        // Super admin
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Enseignant ne peut modifier que son propre profil
        if ($user->isTeacher() && $user->teacher?->id === $teacher->id) {
            return true;
        }

        return false;
    }

    public function delete(User $user, Teacher $teacher): bool
    {
        return $user->isSuperAdmin();
    }

    public function viewStatistics(User $user, Teacher $teacher): bool
    {
        // Super admin voit les stats de tous
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Enseignant ne voit que ses propres stats
        if ($user->isTeacher()) {
            return $user->teacher?->id === $teacher->id;
        }

        return false;
    }

    public function viewEvaluations(User $user, Teacher $teacher): bool
    {
        // Super admin voit toutes les évaluations
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Enseignant voit ses propres évaluations
        if ($user->isTeacher()) {
            return $user->teacher?->id === $teacher->id;
        }

        return false;
    }
}
