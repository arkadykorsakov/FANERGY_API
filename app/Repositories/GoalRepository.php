<?php

namespace App\Repositories;

use App\Models\Goal;
use App\Repositories\Interfaces\GoalRepositoryInterface;

class GoalRepository implements GoalRepositoryInterface
{
    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Goal::with('user')->get();

    }

    public function create(array $data): Goal
    {
        return Goal::create($data)->fresh();
    }

    public function update(Goal $goal, array $data): Goal
    {
        $goal->update($data);
        $goal->refresh();
        return $goal;
    }

    public function delete(Goal $goal): bool
    {
        return $goal->delete();
    }
}
