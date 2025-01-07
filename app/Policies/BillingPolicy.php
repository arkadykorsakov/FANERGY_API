<?php

namespace App\Policies;

use App\Models\Billing;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BillingPolicy
{

    public function update(User $user, Billing $billing): bool
    {
        return $user->id === $billing->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Billing $billing): bool
    {
        return $user->id === $billing->user_id;
    }

}
