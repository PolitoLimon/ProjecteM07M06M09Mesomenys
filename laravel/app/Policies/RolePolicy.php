<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user)
    {
        return $user->role_id === 3;
    }

    public function create(User $user)
    {
        return $user->role_id === 3;
    }

    public function update(User $user)
    {
        return $user->role_id === 3;
    }

    public function view(User $user)
    {
        return $user->role_id === 3;
    }

    public function delete(User $user)
    {
        return $user->role_id === 3;
    }
}

