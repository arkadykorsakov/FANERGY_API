<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserService
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function getUserByNickname(string $nickname):User
    {
        return $this->userRepository->firstOrFail( $nickname, 'nickname');
    }

    public function getPostsPaginatedByUser(string $value, string $column = 'id', int $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $user = $this->userRepository->firstOrFail($value, $column);
        return $this->userRepository->postsPaginated($user, $perPage);
    }

    public function getGoalsPaginatedByUser(string $value, string $column = 'id', int $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $user = $this->userRepository->firstOrFail($value, $column);
        return $this->userRepository->goalsPaginated($user, $perPage);
    }
}
