<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Goal\GoalResource;
use App\Http\Resources\Post\PostResource;
use App\Models\User;
use App\Services\GoalService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function posts(string $nickname): \Illuminate\Http\JsonResponse
    {
        $postsPaginated = $this->userService->getPostsPaginatedByUser(value: $nickname, column: 'nickname');
        return response()->json(['posts' => PostResource::collection($postsPaginated)->response()->getData(true)]);
    }

    public function goals(string $nickname): \Illuminate\Http\JsonResponse
    {
        $goalsPaginated = $this->userService->getGoalsPaginatedByUser(value: $nickname, column: 'nickname');
        return response()->json(['goals' => GoalResource::collection($goalsPaginated)->response()->getData(true)]);
    }
}
