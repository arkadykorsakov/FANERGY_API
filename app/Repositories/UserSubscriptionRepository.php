<?php

namespace App\Repositories;

use App\Models\UserSubscription;
use App\Repositories\Interfaces\UserSubscriptionRepositoryInterface;


class UserSubscriptionRepository implements UserSubscriptionRepositoryInterface
{
    public function findForAuthByAuthor(int $authorId): \App\Models\UserSubscription
    {
        return UserSubscription::where('subscriber_id', auth()->id())->where('author_id', $authorId)->first();
    }

    public function update($subscription, array $data): UserSubscription
    {
        $subscription->update($data);
        $subscription->refresh();
        return $subscription;
    }
}
