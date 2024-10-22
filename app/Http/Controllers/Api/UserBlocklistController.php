<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserBlocklistService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UserBlocklistController extends Controller
{
    public function __construct(private UserBlocklistService $userBlocklistService)
    {
    }
    public function blockUser(User $blockedUser): Response
    {
        Gate::authorize('block-user', $blockedUser);
        $this->userBlocklistService->blockUser($blockedUser);
        return response()->noContent();
    }

    public function unblockUser(User $blockedUser): Response
    {
        Gate::authorize('unblock-user', $blockedUser);
        $this->userBlocklistService->unblockUser($blockedUser);
        return response()->noContent();
    }
}
