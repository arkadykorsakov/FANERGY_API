<?php

namespace App\Services\Post\Factories\Interfaces;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;

interface PostInterface
{
    public function create(PostRepositoryInterface $postRepository, StoreRequest $request): Post;

    public function update(PostRepositoryInterface $postRepository, Post $post, UpdateRequest $request): Post;

    public function validate(StoreRequest|UpdateRequest $request): void;
}
