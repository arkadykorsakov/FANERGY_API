<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\Interfaces\UserPostAccessRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserPostAccessService
{
    public function __construct(private UserPostAccessRepositoryInterface $userPostAccessRepository)
    {
    }

    public function buyShowAccessForPost(Post $post): void
    {
        if ($post->price == 0) {
            throw new HttpException(400);
        }
        // TODO: сделать оплату
        // $price = $post['price'];
        $this->userPostAccessRepository->create(['post_id' => $post->id, 'user_id' => auth()->id()]);
    }
}
