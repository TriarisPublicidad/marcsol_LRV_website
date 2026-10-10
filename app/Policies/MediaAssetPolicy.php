<?php

namespace App\Policies;

use App\Models\MediaAsset;
use App\Models\User;

class MediaAssetPolicy
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
        return $user->can('manage_media') || $user->hasAnyRole(['Administrador', 'Supervisor', 'Editor']);
    }

    public function view(User $user, MediaAsset $media): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->can('manage_media') || $user->hasAnyRole(['Administrador', 'Supervisor', 'Editor']);
    }

    public function update(User $user, MediaAsset $media): bool
    {
        return $user->can('manage_media') || $user->hasAnyRole(['Administrador', 'Supervisor', 'Editor']);
    }

    public function delete(User $user, MediaAsset $media): bool
    {
        return $user->hasAnyRole(['SuperAdmin', 'Administrador']);
    }

    public function restore(User $user, MediaAsset $media): bool
    {
        return $user->hasAnyRole(['SuperAdmin', 'Administrador']);
    }

    public function forceDelete(User $user, MediaAsset $media): bool
    {
        return $user->hasRole('SuperAdmin');
    }
}
