<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Http\UploadedFile;

interface UserSubscriptionRepositoryInterface
{
    public function findForAuthByAuthor(int $authorId): UserSubscription;
    public function update(UserSubscription $subscription, array $data): UserSubscription;
}
