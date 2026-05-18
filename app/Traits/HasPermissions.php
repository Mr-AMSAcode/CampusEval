<?php

namespace App\Traits;

/**
 * Trait HasPermissions pour gérer les permissions granulaires.
 * Chaque rôle a ses permissions propres.
 */
trait HasPermissions
{
    /**
     * Vérifier si l'utilisateur peut accéder au dashboard de gestion.
     */
    public function canAccessManagement(): bool
    {
        return $this->isSuperAdmin() || $this->isTeacher() || $this->isStaff();
    }

    /**
     * Vérifier si l'utilisateur peut voir les données sensibles.
     */
    public function canViewSensitiveData(): bool
    {
        return $this->isSuperAdmin();
    }

    /**
     * Vérifier si l'utilisateur peut gérer les utilisateurs.
     */
    public function canManageUsers(): bool
    {
        return $this->isSuperAdmin();
    }

    /**
     * Vérifier si l'utilisateur peut gérer les classes.
     */
    public function canManageClasses(): bool
    {
        return $this->isSuperAdmin();
    }

    /**
     * Vérifier si l'utilisateur peut gérer les départements.
     */
    public function canManageDepartments(): bool
    {
        return $this->isSuperAdmin();
    }

    /**
     * Vérifier si l'utilisateur peut créer des évaluations.
     */
    public function canCreateEvaluation(): bool
    {
        return $this->isStudent() || $this->isSuperAdmin();
    }

    /**
     * Vérifier si l'utilisateur peut voir les statistiques.
     */
    public function canViewStatistics(): bool
    {
        return true; // Tout le monde peut voir ses propres stats
    }

    /**
     * Vérifier si l'utilisateur peut voir les statistiques globales.
     */
    public function canViewGlobalStatistics(): bool
    {
        return $this->isSuperAdmin();
    }

    /**
     * Vérifier si l'utilisateur peut modérer les évaluations.
     */
    public function canModerateEvaluations(): bool
    {
        return $this->isSuperAdmin();
    }

    /**
     * Vérifier si l'utilisateur peut exporter les données.
     */
    public function canExportData(): bool
    {
        return $this->isSuperAdmin() || $this->isTeacher() || $this->isStaff();
    }

    /**
     * Obtenir toutes les permissions de l'utilisateur.
     */
    public function getPermissions(): array
    {
        return match($this->role) {
            'super_admin' => [
                'view_dashboard',
                'manage_users',
                'manage_classes',
                'manage_departments',
                'view_all_evaluations',
                'view_statistics',
                'export_data',
                'moderate_content',
                'send_notifications',
            ],
            'teacher' => [
                'view_dashboard',
                'view_own_statistics',
                'view_evaluations',
                'export_own_data',
            ],
            'staff' => [
                'view_dashboard',
                'view_own_statistics',
                'view_evaluations',
                'export_own_data',
            ],
            'student' => [
                'view_dashboard',
                'create_evaluation',
                'view_own_evaluations',
                'view_available_staff',
                'view_assigned_teachers',
            ],
            default => [],
        };
    }
}
