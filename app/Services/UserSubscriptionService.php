<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class UserSubscriptionService
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function subscribeToUser(User $followingUser): void
    {
        if($this->userRepository->isFollowing($followingUser)){
            throw new ConflictHttpException();
        }
        $this->userRepository->subscribeToUser(auth()->user(), $followingUser['id']);
    }

    public function unsubscribeFromUser(User $followingUser): void
    {
        if(!$this->userRepository->isFollowing($followingUser)){
            throw new ConflictHttpException();
        }
        $this->userRepository->unsubscribeFromUser(auth()->user(), $followingUser['id']);
    }

}
