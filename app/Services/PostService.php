<?php

namespace App\Services;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\PostRepository;

class PostService
{
    public function __construct(private postRepository $postRepository)
    {
    }

    public function getPosts(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->postRepository->getAll();
    }

    public function createPost(StoreRequest $request): Post
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $tags = $data['tags'];
        unset($data['tags']);
        $post = $this->postRepository->create($data);
        $this->postRepository->attachTags($post, $tags);
        return $post;
    }

    public function updatePost(Post $post, UpdateRequest $request): Post
    {
        $data = $request->validated();
        $tags = $data['tags'] ?? [];
        unset($data['tags']);
        $post = $this->postRepository->update($post, $data);
        $this->postRepository->syncTags($post, $tags);
        return $post;
    }

    public function deletePost(Post $post): bool
    {
        return $this->postRepository->delete($post);
    }
}
