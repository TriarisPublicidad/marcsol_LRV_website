<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
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
        return $user->can('manage_events') || $user->hasAnyRole(['Administrador', 'Supervisor', 'Operador']);
    }

    public function view(User $user, Event $event): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->can('manage_events') || $user->hasAnyRole(['Administrador', 'Supervisor', 'Operador']);
    }

    public function update(User $user, Event $event): bool
    {
        return $user->can('manage_events') || $user->hasAnyRole(['Administrador', 'Supervisor', 'Operador']);
    }

    public function delete(User $user, Event $event): bool
    {
        return $user->hasAnyRole(['SuperAdmin', 'Administrador', 'Supervisor']);
    }

    public function restore(User $user, Event $event): bool
    {
        return $user->hasAnyRole(['SuperAdmin', 'Administrador', 'Supervisor']);
    }

    public function forceDelete(User $user, Event $event): bool
    {
        return false;
    }
}
