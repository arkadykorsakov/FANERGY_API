<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserSubscriptionService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UserSubscriptionController extends Controller
{
    public function __construct(private UserSubscriptionService $userSubscriptionService)
    {
    }

    public function subscribeToUser(User $followingUser): Response
    {
        Gate::authorize('subscribe-user', $followingUser);
        $this->userSubscriptionService->subscribeToUser($followingUser);
        return response()->noContent(Response::HTTP_CREATED);
    }

    public function unsubscribeFromUser(User $followingUser): Response
    {
        Gate::authorize('unsubscribe-user', $followingUser);
        $this->userSubscriptionService->unsubscribeFromUser($followingUser);
        return response()->noContent();
    }
}
