<?php

namespace App\Policies;

use App\Models\Evaluation;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Staff;

/**
 * EvaluationPolicy - Contrôle l'accès aux évaluations
 * 
 * Sécurité critique: Garantir l'anonymité des évaluations
 */
class EvaluationPolicy
{
    /**
     * Voir la liste des évaluations.
     */
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Voir une évaluation spécifique.
     */
    public function view(User $user, Evaluation $evaluation): bool
    {
        // Super admin peut voir toutes les évaluations
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Enseignant/Personnel ne peuvent voir que leurs propres évaluations
        if ($user->isTeacher() && $evaluation->evaluatable_type === Teacher::class) {
            $teacher = $user->teacher;
            return $teacher && $evaluation->evaluatable_id === $teacher->id;
        }

        if ($user->isStaff() && $evaluation->evaluatable_type === Staff::class) {
            $staff = $user->staff;
            return $staff && $evaluation->evaluatable_id === $staff->id;
        }

        // Les étudiants ne voient jamais les évaluations (anonymité!)
        return false;
    }

    /**
     * Créer une évaluation.
     */
    public function create(User $user): bool
    {
        return $user->isStudent();
    }

    /**
     * Mettre à jour une évaluation (avant publication seulement).
     */
    public function update(User $user, Evaluation $evaluation): bool
    {
        // Super admin uniquement
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Les étudiants ne peuvent pas modifier leurs évaluations une fois créées
        // (pour maintenir l'anonymité et l'intégrité)
        return false;
    }

    /**
     * Supprimer une évaluation.
     */
    public function delete(User $user, Evaluation $evaluation): bool
    {
        // Super admin uniquement pour raisons de modération
        return $user->isSuperAdmin();
    }

    /**
     * Modérer une évaluation (revoir avant publication).
     */
    public function moderate(User $user, Evaluation $evaluation): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Exporter les données d'évaluation.
     */
    public function export(User $user): bool
    {
        return $user->isSuperAdmin();
    }
}
