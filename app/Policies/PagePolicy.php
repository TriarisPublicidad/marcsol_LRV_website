<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;

class PagePolicy
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
        return $user->can('manage_pages') || $user->hasAnyRole(['Administrador', 'Supervisor']);
    }

    public function view(User $user, Page $page): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->can('manage_pages') || $user->hasAnyRole(['Administrador', 'Supervisor']);
    }

    public function update(User $user, Page $page): bool
    {
        return $user->can('manage_pages') || $user->hasAnyRole(['Administrador', 'Supervisor']);
    }

    public function delete(User $user, Page $page): bool
    {
        return $user->hasAnyRole(['SuperAdmin', 'Administrador']);
    }

    public function restore(User $user, Page $page): bool
    {
        return $user->hasAnyRole(['SuperAdmin', 'Administrador']);
    }

    public function forceDelete(User $user, Page $page): bool
    {
        return false;
    }
}
