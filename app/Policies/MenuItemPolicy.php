<?php

namespace App\Policies;

use App\Models\MenuItem;
use App\Models\User;

class MenuItemPolicy
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
        return $user->can('manage_menus') || $user->hasRole('Administrador');
    }

    public function view(User $user, MenuItem $item): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $this->viewAny($user);
    }

    public function update(User $user, MenuItem $item): bool
    {
        return $this->viewAny($user);
    }

    public function delete(User $user, MenuItem $item): bool
    {
        return $this->viewAny($user);
    }

    public function restore(User $user, MenuItem $item): bool
    {
        return $this->viewAny($user);
    }

    public function forceDelete(User $user, MenuItem $item): bool
    {
        return false;
    }
}
