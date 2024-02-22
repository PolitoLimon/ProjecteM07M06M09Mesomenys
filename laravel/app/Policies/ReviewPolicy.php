<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    /**
     * Determina si el usuario puede ver la lista de lugares.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role_id, [1, 2, 3]);
    }

    /**
     * Determina si el usuario puede ver un lugar específico.
     */
    public function view(User $user, Review $review): bool
    {
        return in_array($user->role_id, [1, 2, 3]);
    }
    
    /**
     * Determina si el usuario puede crear lugares.
     */
    public function create(User $user): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determina si el usuario puede actualizar un lugar específico.
     */
    public function update(User $user, Review $review): bool
    {
        //
    }

    /**
     * Determina si el usuario puede eliminar un lugar específico.
     */
    public function delete(User $user, Review $review): bool
    {
        return $user->role_id === 1 || $user->id == $user->role_id = 1;
    }

    /**
     * Determina si el usuario puede restaurar un lugar.
     */
    public function restore(User $user, Place $place): bool
    {
        //
    }

    /**
     * Determina si el usuario puede forzar la eliminación de un lugar.
     */
    public function forceDelete(User $user, Place $place): bool
    {
        //
    }
}
