<?php

namespace App\Services\Post\Factories;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;

abstract class AbstractPost
{
    protected function createPost(PostRepositoryInterface $postRepository, StoreRequest $request, array $fields): Post
    {
        $data = $request->safe()->only($fields);
        $data['user_id'] = $request->user()->id;
        $tags = $request->validated()['tags'] ?? [];
        $post = $postRepository->create($data);
        $postRepository->attachTags($post, $tags);
        return $post;
    }

    protected function updatePost(PostRepositoryInterface $postRepository, Post $post, UpdateRequest $request, array $fields): Post
    {
        $data = $request->safe()->only($fields);
        $tags = $request->validated()['tags'] ?? [];
        $post = $postRepository->update($post, $data);
        $postRepository->syncTags($post, $tags);
        return $post;
    }
}
