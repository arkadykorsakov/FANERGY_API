<?php

namespace App\Repositories\Interfaces;

use App\Models\Post;
use Illuminate\Http\UploadedFile;

interface PostRepositoryInterface
{
    public function getAll(): \Illuminate\Database\Eloquent\Collection;

    public function create(array $data): Post;

    public function update(Post $post, array $data): Post;

    public function delete(Post $post): bool;

    public function attachTags(Post $post, array $tags): void;

    public function syncTags(Post $post, array $tags): void;

    public function attachLevels(Post $post, array $levels): void;

    public function syncLevels(Post $post, array $levels): void;

    public function attachLike(Post $post, int $userId): void;

    public function detachLike(Post $post, int $userId): void;

    public function attachRepost(Post $post, int $userId): void;

    public function detachRepost(Post $post, int $userId): void;

    public function hasLiked(Post $post): bool;

    public function hasReposted(Post $post): bool;

    public function addMedia(Post $post, UploadedFile $file, string $collectionName): void;

    public function clearMediaCollection(Post $post): void;
}
