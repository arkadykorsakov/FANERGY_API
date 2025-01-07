<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Billing\StoreRequest;
use App\Http\Resources\Billing\BillingResource;
use App\Http\Resources\Goal\GoalResource;
use App\Http\Resources\Post\PostResource;
use App\Services\MeDataService;

class MeDataController extends Controller
{
    public function __construct(private MeDataService $meDataService)
    {
    }

    public function posts(): \Illuminate\Http\JsonResponse
    {
        $posts = $this->meDataService->getPostsByMe();
        return response()->json(['posts' => PostResource::collection($posts)]);
    }

    public function billings(): \Illuminate\Http\JsonResponse
    {
        $billings = $this->meDataService->getBillingsByMe();
        return response()->json(['billings' => BillingResource::collection($billings)]);
    }

    public function goals(): \Illuminate\Http\JsonResponse
    {
        $goals = $this->meDataService->getGoalsByMe();
        return response()->json(['goals' => GoalResource::make($goals)]);
    }

}
