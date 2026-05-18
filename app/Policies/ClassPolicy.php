<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ClassModel;

class ClassPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ClassModel $class): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function update(User $user, ClassModel $class): bool
    {
        return $user->isSuperAdmin();
    }

    public function delete(User $user, ClassModel $class): bool
    {
        return $user->isSuperAdmin();
    }
}
