<?php

namespace App\Policies;

use App\Models\Goal;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GoalPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Goal $goal): bool
    {
        return $user->id == $goal->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Goal $goal): bool
    {
        return $user->id == $goal->user_id;
    }
}
