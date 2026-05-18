<?php

namespace App\Traits;

/**
 * Trait HasRoles permet la gestion des rôles utilisateur.
 * 
 * Rôles disponibles:
 * - super_admin: Accès complet
 * - student: Étudiant
 * - teacher: Enseignant
 * - staff: Personnel administratif
 */
trait HasRoles
{
    /**
     * Vérifier si l'utilisateur a le rôle spécifié.
     */
    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role, $roles);
    }

    /**
     * Vérifier si l'utilisateur a un des rôles parmi une liste.
     */
    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }

    /**
     * Vérifier si l'utilisateur est un super admin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Vérifier si l'utilisateur est un étudiant.
     */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    /**
     * Vérifier si l'utilisateur est un enseignant.
     */
    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    /**
     * Vérifier si l'utilisateur est un personnel.
     */
    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    /**
     * Vérifier si l'utilisateur ne peut éditer que ses propres données.
     */
    public function isRegularUser(): bool
    {
        return in_array($this->role, ['student', 'teacher', 'staff']);
    }

    /**
     * Obtenir le libellé du rôle.
     */
    public function getRoleLabel(): string
    {
        return match($this->role) {
            'super_admin' => 'Administrateur Principal',
            'student' => 'Étudiant',
            'teacher' => 'Enseignant',
            'staff' => 'Personnel Administratif',
            default => ucfirst($this->role),
        };
    }
}
