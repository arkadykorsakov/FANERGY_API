<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class MeDataService
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function getBillingsByMe(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->userRepository->billings(auth()->user());
    }

    public function getPostsByMe(int $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->userRepository->postsPaginated(auth()->user(), $perPage);

    }

    public function getGoalsByMe(int $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->userRepository->goalsPaginated(auth()->user(), $perPage);
    }
}
