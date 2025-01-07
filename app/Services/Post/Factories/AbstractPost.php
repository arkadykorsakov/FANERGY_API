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
        $currentSubscriptionLevel = (int)$request['subscription_level_id'];
        $data = $request->safe()->only(...$fields);
        $data['user_id'] = $request->user()->id;
        $tags = $request->validated()['tags'] ?? [];
        $post = $postRepository->create($data);
        $postRepository->attachTags($post, $tags);
        if ($currentSubscriptionLevel) {
            $subscriptionLevels = auth()->user()
                ->subscriptionLevels()
                ->orderBy('order', 'ASC')
                ->pluck('id')
                ->toArray();
            $idxCurrentSubscriptionLevel = array_search($currentSubscriptionLevel, $subscriptionLevels);
            $allowedSubscriptionLevels = array_splice($subscriptionLevels, $idxCurrentSubscriptionLevel);
            $postRepository->attachLevels($post, $allowedSubscriptionLevels);
        }
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
