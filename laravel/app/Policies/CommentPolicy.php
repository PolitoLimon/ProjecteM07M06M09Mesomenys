<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        //
        if ($user->role_id === 1 && $user->id === $comment->author_id) {
            return $user->role_id;
        } elseif ($user->role_id === 2) {
            return true;
        }
        return false;
        
    }
}