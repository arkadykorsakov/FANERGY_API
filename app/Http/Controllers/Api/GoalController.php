<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Goal\StoreRequest;
use App\Http\Requests\Goal\UpdateRequest;
use App\Http\Resources\Goal\GoalResource;
use App\Models\Goal;
use App\Services\GoalService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class GoalController extends Controller
{
	public function __construct(private GoalService $goalService)
	{
	}

	public function index(): \Illuminate\Http\JsonResponse
	{
		$goals = $this->goalService->getGoals();
		return response()->json(['goals' => GoalResource::collection($goals)]);
	}

	public function store(StoreRequest $request): \Illuminate\Http\JsonResponse
	{
		$goal = $this->goalService->createGoal($request);
		return response()->json(['goal' => GoalResource::make($goal)], Response::HTTP_CREATED);
	}

	public function update(UpdateRequest $request, Goal $goal): \Illuminate\Http\JsonResponse
	{
        Gate::authorize('update-goal', $goal);
		$goal = $this->goalService->updateGoal($goal, $request);
		return response()->json(['goal' => GoalResource::make($goal)]);
	}

	public function destroy(Goal $goal): \Illuminate\Http\Response
	{
        Gate::authorize('delete-goal', $goal);
		$this->goalService->deleteGoal($goal);
		return response()->noContent();
	}
}
