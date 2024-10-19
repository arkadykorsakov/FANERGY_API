<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Goal\GoalResource;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\User\ProfileResource;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function show(string $nickname): \Illuminate\Http\JsonResponse
    {
        return response()->json(['user' => ProfileResource::make($this->userService->getUserByNickname($nickname))]);
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
