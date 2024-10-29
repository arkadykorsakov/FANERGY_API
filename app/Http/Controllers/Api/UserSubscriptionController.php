<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subscribe\BuyRequest;
use App\Http\Requests\Subscribe\ProlongRequest;
use App\Http\Requests\Subscribe\UpgradeRequest;
use App\Models\User;
use App\Services\UserSubscriptionService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

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

    public function buyLevelSubscriptionForUser(User $author, BuyRequest $request): Response
    {
        $this->userSubscriptionService->buyLevelSubscriptionForUser($author, $request);
        return response()->noContent();
    }

    public function upgradeSubscriptionLevelForUser(User $author, UpgradeRequest $request): Response
    {
        $this->userSubscriptionService->upgradeSubscriptionLevelForUser($author, $request);
        return response()->noContent();
    }

    public function prolongSubscriptionLevelForUser(User $author, ProlongRequest $request): Response
    {
        $this->userSubscriptionService->prolongSubscriptionLevelForUser($author, $request);
        return response()->noContent();
    }

    public function unsubscribeFromUser(User $author): Response
    {
        $this->userSubscriptionService->unsubscribeFromUser($author);
        return response()->noContent();
    }
}
