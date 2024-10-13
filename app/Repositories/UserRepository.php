<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

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
}
