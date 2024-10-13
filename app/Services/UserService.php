<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;

class UserService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
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
