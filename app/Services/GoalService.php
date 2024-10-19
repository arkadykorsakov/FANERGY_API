<?php

namespace App\Services;

use App\Http\Requests\Goal\StoreRequest;
use App\Http\Requests\Goal\UpdateRequest;
use App\Models\Goal;
use App\Repositories\Interfaces\GoalRepositoryInterface;

class GoalService
{
    private GoalRepositoryInterface $goalRepository;

    public function __construct(GoalRepositoryInterface $goalRepository)
    {
        $this->goalRepository = $goalRepository;
    }

    public function getGoals(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->goalRepository->getAll();
    }

    public function createGoal(StoreRequest $request): Goal
    {
        return $this->goalRepository->create(array_merge($request->validated(), ['user_id' => $request->user()->id]));
    }

    public function updateGoal(Goal $goal, UpdateRequest $request): Goal
    {
        return $this->goalRepository->update($goal, $request->validated());
    }

    public function deleteGoal(Goal $goal): bool
    {
        return $this->goalRepository->delete($goal);
    }
}
