<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
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
        return $user->can('manage_users');
    }

    public function view(User $user, User $model): bool
    {
        return $user->can('manage_users') || $user->id === $model->id;
    }

    public function create(User $user): bool
    {
        return $user->can('manage_users');
    }

    public function update(User $user, User $model): bool
    {
        return $user->can('manage_users') || $user->id === $model->id;
    }

    public function delete(User $user, User $model): bool
    {
        // No permitir auto-eliminaciÃ³n
        return $user->can('manage_users') && $user->id !== $model->id;
    }

    public function restore(User $user, User $model): bool
    {
        return $user->hasRole('SuperAdmin');
    }

    public function forceDelete(User $user, User $model): bool
    {
        // Prohibido borrado fÃ­sico segÃºn reglas arquitectÃ³nicas
        return false;
    }
}
