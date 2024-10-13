<?php

namespace App\Repositories\Interfaces;

use App\Models\Post;

interface PostRepositoryInterface
{
	public function getAll(): \Illuminate\Database\Eloquent\Collection;

	public function create(array $data): Post;

	public function update(Post $post, array $data): Post;

	public function delete(Post $post): bool;

	public function attachTags(Post $post, array $tags): void;

	public function syncTags(Post $post, array $tags): void;
}
