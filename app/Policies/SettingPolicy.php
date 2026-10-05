<?php

namespace App\Policies;

use App\Models\Setting;
use App\Models\User;

class SettingPolicy
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
        return $user->can('manage_settings') || $user->hasRole('Administrador');
    }

    public function view(User $user, Setting $setting): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $this->viewAny($user);
    }

    public function update(User $user, Setting $setting): bool
    {
        return $this->viewAny($user);
    }

    public function delete(User $user, Setting $setting): bool
    {
        return $this->viewAny($user);
    }

    public function restore(User $user, Setting $setting): bool
    {
        return $this->viewAny($user);
    }

    public function forceDelete(User $user, Setting $setting): bool
    {
        return false;
    }
}
