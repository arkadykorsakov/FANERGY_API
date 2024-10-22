<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class UserRepository implements UserRepositoryInterface
{
    public function findByEmail($value): User|null
    {
        return User::where('email', $value)->first();
    }

    public function firstOrFail(string $value, string $column = 'id'): User
    {
        return User::where($column, $value)->firstOrFail();
    }

    public function create(array $data): User
    {
        return User::create($data)->refresh();
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        $user->refresh();
        return $user;
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }

    public function deleteTokens(User $user): int
    {
        return $user->tokens()->delete();
    }

    public function postsPaginated(User $user, int $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $user->posts()->paginate($perPage);
    }

    public function goalsPaginated(User $user, int $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $user->goals()->paginate($perPage);
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function addMedia(User $user, UploadedFile $file, string $collectionName): void
    {
        $user->addMedia($file)
            ->toMediaCollection($collectionName);
    }

    public function clearMediaCollection(User $user): void
    {
        $user->clearMediaCollection();
    }

    public function subscribeToUser(User $user, int $followingId): void
    {
        $user->subscribes()->attach($followingId);
    }

    public function unsubscribeFromUser(User $user, int $followingId): void
    {
        $user->subscribes()->detach($followingId);
    }

    public function blockUser(User $user, $blockedUserId): void
    {
        $user->blocklist()->attach($blockedUserId);
    }

    public function unblockUser(User $user, $blockedUserId): void
    {
        $user->blocklist()->detach($blockedUserId);
    }

    public function isFollowing(User $user): bool
    {
       return $user->isFollowing;
    }

    public function isFollowed(User $user): bool
    {
        return $user->isFollowed;
    }

    public function isUserBlockedByMe(User $user): bool
    {
        return $user->isUserBlockedByMe ;
    }
}
