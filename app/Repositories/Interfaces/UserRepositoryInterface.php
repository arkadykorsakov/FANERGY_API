<?php

namespace App\Repositories\Interfaces;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\UploadedFile;

interface UserRepositoryInterface
{
    public function findByEmail($value): User|null;

    public function firstOrFail(string $value, string $column = 'id'): User;

    public function create(array $data): User;

    public function update(User $user, array $data): User;

    public function delete(User $user): bool;

    public function deleteTokens(User $user): int;

    public function postsPaginated(User $user, int $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    public function goalsPaginated(User $user, int $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    public function addMedia(User $user, UploadedFile $file, string $collectionName): void;
    public function clearMediaCollection(User $user): void;

}
