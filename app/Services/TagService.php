<?php

namespace App\Services;

use App\Http\Requests\Tag\StoreRequest;
use App\Models\Tag;
use App\Repositories\Interfaces\TagRepositoryInterface;

class TagService
{
	private TagRepositoryInterface $tagRepository;

	public function __construct(TagRepositoryInterface $tagRepository)
	{
		$this->tagRepository = $tagRepository;
	}

	public function getTags(): \Illuminate\Database\Eloquent\Collection
	{
		return $this->tagRepository->getAll();
	}

	public function createTag(StoreRequest $request): Tag
	{
		$data = $request->validated();
		return $this->tagRepository->create($data)->refresh();
	}
}
