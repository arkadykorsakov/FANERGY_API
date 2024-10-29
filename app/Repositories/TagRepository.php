<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Repositories\Interfaces\TagRepositoryInterface;

class TagRepository implements TagRepositoryInterface
{
	public function getAll(): \Illuminate\Database\Eloquent\Collection
	{
		return Tag::all();
	}

	public function create(array $data): Tag
	{
		return Tag::create($data)->fresh();
	}
}
