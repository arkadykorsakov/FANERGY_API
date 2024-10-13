<?php

namespace App\Services;

use App\Http\Requests\Goal\StoreRequest;
use App\Http\Requests\Goal\UpdateRequest;
use App\Models\Goal;
use App\Repositories\Interfaces\GoalRepositoryInterface;
use Illuminate\Support\Facades\Gate;

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
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        return $this->goalRepository->create($data);
    }

    public function updateGoal(Goal $goal, UpdateRequest $request): Goal
    {
        $data = $request->validated();
        return $this->goalRepository->update($goal, $data);
    }

    public function deleteGoal(Goal $goal): bool
    {
        return $this->goalRepository->delete($goal);
    }
}
