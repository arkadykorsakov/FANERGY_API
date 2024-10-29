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
        return User::create($data)->fresh();
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
        return $user->posts()
            ->with(['author', 'tags', 'media'])
            ->withCount(['likes', 'reposts'])
            ->paginate($perPage);
    }

    public function goalsPaginated(User $user, int $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $user->goals()->with('user')->paginate($perPage);
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

    public function clearMediaCollection(User $user, string $collectionName): void
    {
        $user->clearMediaCollection($collectionName);
    }

    public function subscribeToUser(User $user, int $followingId): void
    {
        $user->subscriptions()->attach($followingId);
    }

    public function unsubscribeFromUser(User $user, int $followingId): void
    {
        $user->subscriptions()->detach($followingId);
    }

    public function blockUser(User $user, $blockedUserId): void
    {
        $user->blockedUsers()->attach($blockedUserId);
    }

    public function unblockUser(User $user, $blockedUserId): void
    {
        $user->blockedUsers()->detach($blockedUserId);
    }

    public function isSubscribedByAuth(User $user): bool
    {
        return $user->isSubscribedByAuth;
    }

    public function isSubscribedToAuth(User $user): bool
    {
        return $user->isSubscribedToAuth;
    }

    public function isBlockedByAuth(User $user): bool
    {
        return $user->isBlockedByAuth;
    }

    public function findAuthUserSubscription(int $authorId)
    {
        return auth()->user()->subscriptions()->where('author_id', $authorId)->first()?->pivot;
    }

    public function updateSubscription($subscription, array $data): void
    {
        $subscription->update($data);
    }
}
