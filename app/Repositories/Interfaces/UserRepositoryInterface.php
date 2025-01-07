<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function billings(User $user): \Illuminate\Database\Eloquent\Collection;

    public function addMedia(User $user, UploadedFile $file, string $collectionName): void;

    public function clearMediaCollection(User $user, string $collectionName): void;

    public function subscribeToUser(User $user, int $followingId): void;

    public function unsubscribeFromUser(User $user, int $followingId): void;

    public function blockUser(User $user, $blockedUserId): void;

    public function unblockUser(User $user, $blockedUserId): void;

    public function isSubscribedByAuth(User $user): bool;

    public function isSubscribedToAuth(User $user): bool;

    public function isBlockedByAuth(User $user): bool;
}
