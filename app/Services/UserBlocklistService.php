<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class UserBlocklistService
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function blockUser(User $blockedUser): void
    {
        if($this->userRepository->isBlockedByAuth($blockedUser)){
            throw new ConflictHttpException();
        }
        $this->userRepository->blockUser(auth()->user(), $blockedUser['id']);
    }

    public function unblockUser(User $blockedUser): void
    {
        if(!$this->userRepository->isBlockedByAuth($blockedUser)){
            throw new ConflictHttpException();
        }
        $this->userRepository->unblockUser(auth()->user(), $blockedUser['id']);
    }

}
