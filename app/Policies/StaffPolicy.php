<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Staff;

class StaffPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Tous peuvent voir la liste du personnel
    }

    public function view(User $user, Staff $staff): bool
    {
        return true; // Tous peuvent voir un personnel
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function update(User $user, Staff $staff): bool
    {
        // Super admin
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Personnel ne peut modifier que son propre profil
        if ($user->isStaff() && $user->staff?->id === $staff->id) {
            return true;
        }

        return false;
    }

    public function delete(User $user, Staff $staff): bool
    {
        return $user->isSuperAdmin();
    }

    public function viewStatistics(User $user, Staff $staff): bool
    {
        // Super admin voit les stats de tous
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Personnel ne voit que ses propres stats
        if ($user->isStaff()) {
            return $user->staff?->id === $staff->id;
        }

        return false;
    }

    public function viewEvaluations(User $user, Staff $staff): bool
    {
        // Super admin voit toutes les évaluations
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Personnel voit ses propres évaluations
        if ($user->isStaff()) {
            return $user->staff?->id === $staff->id;
        }

        return false;
    }
}
