<?php

namespace App\Policies;

use App\Models\Promotion;
use App\Models\User;

class PromotionPolicy
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
        return $user->can('manage_promotions') || $user->hasAnyRole(['Administrador', 'Supervisor', 'Operador']);
    }

    public function view(User $user, Promotion $promotion): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->can('manage_promotions') || $user->hasAnyRole(['Administrador', 'Supervisor', 'Operador']);
    }

    public function update(User $user, Promotion $promotion): bool
    {
        return $user->can('manage_promotions') || $user->hasAnyRole(['Administrador', 'Supervisor', 'Operador']);
    }

    public function delete(User $user, Promotion $promotion): bool
    {
        // Solo Admin y Supervisor pueden inactivar/borrar lógicamente
        return $user->hasAnyRole(['SuperAdmin', 'Administrador', 'Supervisor']);
    }

    public function restore(User $user, Promotion $promotion): bool
    {
        return $user->hasAnyRole(['SuperAdmin', 'Administrador', 'Supervisor']);
    }

    public function forceDelete(User $user, Promotion $promotion): bool
    {
        // Estrictamente prohibido borrado físico
        return false;
    }
}
