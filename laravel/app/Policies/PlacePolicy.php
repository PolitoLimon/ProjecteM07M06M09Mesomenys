<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Place;

class PlacePolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Place $place)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->role_id === '1';
    }

    public function update(User $user, Place $place)
    {
        return $user->role_id === 2;
    }

    public function delete(User $user, Place $place)
    {
        return $user->role_id === 2;
    }
    public function favorite(User $user, Place $place)
    {
        return $user->role_id === 1;
    }

    public function unfavorite(User $user, Place $place)
    {
        return $user->role_id === 1;
    }
}
