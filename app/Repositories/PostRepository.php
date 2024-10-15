<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Post::all();
    }

    public function create(array $data): Post
    {
        return Post::create($data)->refresh();
    }

    public function update(Post $post, array $data): Post
    {
        $post->update($data);
        $post->refresh();
        return $post;
    }

    public function delete(Post $post): bool
    {
        return $post->delete();
    }

    public function attachTags(Post $post, array $tags): void
    {
        $post->tags()->attach($tags);
    }

    public function syncTags(Post $post, array $tags): void
    {
        $post->tags()->sync($tags);
    }
}
