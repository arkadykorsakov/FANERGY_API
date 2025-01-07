<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subscribe\BuyRequest;
use App\Http\Requests\Subscribe\ProlongRequest;
use App\Http\Requests\Subscribe\UpgradeRequest;
use App\Http\Requests\UserSubscription\UpdateRequest;
use App\Models\User;
use App\Models\UserSubscription;
use App\Services\UserSubscriptionService;
use Illuminate\Http\Response;

class UserSubscriptionController extends Controller
{
    public function __construct(private UserSubscriptionService $userSubscriptionService)
    {
    }

    public function subscribeToUser(User $author): Response
    {
        $this->userSubscriptionService->subscribeToUser($author);
        return response()->noContent(Response::HTTP_CREATED);
    }

    public function buyLevelSubscriptionForUser(User $author, BuyRequest $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(['user_subscription' => $this->userSubscriptionService->buyLevelSubscriptionForUser($author, $request)]);
    }

    public function upgradeSubscriptionLevelForUser(User $author, UpgradeRequest $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(['user_subscription' => $this->userSubscriptionService->upgradeSubscriptionLevelForUser($author, $request)]);

    }

    public function prolongSubscriptionLevelForUser(User $author, ProlongRequest $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(['user_subscription' => $this->userSubscriptionService->prolongSubscriptionLevelForUser($author, $request)]);
    }

    public function updateSubscription(UserSubscription $subscription, UpdateRequest $request): Response
    {
        $this->userSubscriptionService->updateSubscription($subscription, $request);
        return response()->noContent();
    }

    public function unsubscribeFromUser(User $author): Response
    {
        $this->userSubscriptionService->unsubscribeFromUser($author);
        return response()->noContent();
    }
}
