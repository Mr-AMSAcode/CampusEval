<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Détermine si l'utilisateur peut voir la liste des utilisateurs.
     */
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Détermine si l'utilisateur peut voir un utilisateur.
     */
    public function view(User $user, User $model): bool
    {
        // Super admin peut voir tous les utilisateurs
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Les utilisateurs peuvent voir leur propre profil
        return $user->id === $model->id;
    }

    /**
     * Détermine si l'utilisateur peut créer un utilisateur.
     */
    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Détermine si l'utilisateur peut modifier un utilisateur.
     */
    public function update(User $user, User $model): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Les utilisateurs ne peuvent modifier que leur propre profil
        return $user->id === $model->id;
    }

    /**
     * Détermine si l'utilisateur peut supprimer un utilisateur.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->isSuperAdmin() && $user->id !== $model->id;
    }

    /**
     * Détermine si l'utilisateur peut restaurer un utilisateur.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Détermine si l'utilisateur peut supprimer définitivement un utilisateur.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->isSuperAdmin() && $user->id !== $model->id;
    }
}
