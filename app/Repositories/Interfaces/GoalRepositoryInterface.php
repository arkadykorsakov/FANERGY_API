<?php

namespace App\Repositories\Interfaces;

use App\Models\Goal;

interface GoalRepositoryInterface
{
	public function getAll(): \Illuminate\Database\Eloquent\Collection;

	public function create(array $data): Goal;

	public function update(Goal $goal, array $data): Goal;

	public function delete(Goal $goal): bool;
}
