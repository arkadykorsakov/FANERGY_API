<?php

namespace App\Policies;


use App\Models\User;

class UserSubscriptionPolicy
{
    public function subscribeToUser(User $user, User $following): bool
    {
        return $user->id !== $following->id;
    }

    public function unSubscribeFromUser(User $user, User $following): bool
    {
        return $user->id !== $following->id;
    }
}
