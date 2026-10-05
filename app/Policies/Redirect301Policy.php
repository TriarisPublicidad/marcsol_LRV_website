<?php

namespace App\Policies;

use App\Models\Redirect301;
use App\Models\User;

class Redirect301Policy
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
        return $user->can('manage_redirects') || $user->hasRole('Administrador');
    }

    public function view(User $user, Redirect301 $item): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $this->viewAny($user);
    }

    public function update(User $user, Redirect301 $item): bool
    {
        return $this->viewAny($user);
    }

    public function delete(User $user, Redirect301 $item): bool
    {
        return $this->viewAny($user);
    }

    public function restore(User $user, Redirect301 $item): bool
    {
        return $this->viewAny($user);
    }

    public function forceDelete(User $user, Redirect301 $item): bool
    {
        return false;
    }
}
