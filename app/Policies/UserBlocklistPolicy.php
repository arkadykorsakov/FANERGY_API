<?php

namespace App\Policies;

use App\Models\User;

class UserBlocklistPolicy
{
    public function blockUser(User $user, User $blockedUser): bool
    {
        return $user->id !== $blockedUser->id;
    }

    public function unblockUser(User $user, User $blockedUser): bool
    {
        return $user->id !== $blockedUser->id;
    }
}
