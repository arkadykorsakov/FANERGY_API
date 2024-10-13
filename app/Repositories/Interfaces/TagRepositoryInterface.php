<?php

namespace App\Repositories\Interfaces;

use App\Models\Tag;

interface TagRepositoryInterface
{
	public function getAll(): \Illuminate\Database\Eloquent\Collection;

	public function create(array $data): Tag;
}
