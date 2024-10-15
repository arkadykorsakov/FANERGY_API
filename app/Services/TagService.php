<?php

namespace App\Services;

use App\Http\Requests\Tag\StoreRequest;
use App\Models\Tag;
use App\Repositories\Interfaces\TagRepositoryInterface;

class TagService
{
    public function __construct(private TagRepositoryInterface $tagRepository)
    {
    }

    public function getTags(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->tagRepository->getAll();
    }

    public function createTag(StoreRequest $request): Tag
    {
        return $this->tagRepository->create($request->validated());
    }
}
