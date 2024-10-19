<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

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

    public function attachLike(Post $post, int $userId): void
    {
        $post->likes()->attach($userId);
    }

    public function detachLike(Post $post, int $userId): void
    {
        $post->likes()->detach($userId);

    }

    public function attachRepost(Post $post, int $userId): void
    {
        $post->reposts()->attach($userId);
    }

    public function detachRepost(Post $post, int $userId): void
    {
        $post->reposts()->detach($userId);
    }

    public function hasLiked(Post $post): bool
    {
        return $post->hasLiked;
    }

    public function hasReposted(Post $post): bool
    {
        return $post->hasReposted;
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function addMedia(Post $post, UploadedFile $file, string $collectionName): void
    {
        $post->addMedia($file)
            ->toMediaCollection($collectionName);
    }
    public function clearMediaCollection(Post $post): void
    {
        foreach ($post->media()->pluck('collection_name')->unique() as $collection) {
            $post->clearMediaCollection($collection);
        }
    }
}
