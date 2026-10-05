<?php

namespace App\Policies;

use App\Models\Branch;
use App\Models\User;

class BranchPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('SuperAdmin')) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->can('manage_branches') || $user->hasAnyRole(['Administrador', 'Supervisor']);
    }

    public function view(User $user, Branch $branch): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->can('manage_branches') || $user->hasAnyRole(['Administrador', 'Supervisor']);
    }

    public function update(User $user, Branch $branch): bool
    {
        return $user->can('manage_branches') || $user->hasAnyRole(['Administrador', 'Supervisor']);
    }

    public function delete(User $user, Branch $branch): bool
    {
        return $user->hasAnyRole(['SuperAdmin', 'Administrador']);
    }

    public function restore(User $user, Branch $branch): bool
    {
        return $user->hasAnyRole(['SuperAdmin', 'Administrador']);
    }

    public function forceDelete(User $user, Branch $branch): bool
    {
        return false;
    }
}
