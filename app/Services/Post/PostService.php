<?php

namespace App\Services\Post;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateSubscriptionLevel;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Services\Post\Factories\PostFactory;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Throwable;

class PostService
{
    public function __construct(private postRepository $postRepository)
    {
    }

    public function getPosts(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->postRepository->getAll();
    }

    /**
     * @throws Throwable
     */
    public function createPost(StoreRequest $request): Post
    {
        DB::beginTransaction();
        try {
            $postFactory = PostFactory::createHandler($request['category']);
            $post = $postFactory->create($this->postRepository, $request);
            DB::commit();
            return $post;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws Throwable
     */
    public function updatePost(Post $post, UpdateRequest $request): Post
    {
        DB::beginTransaction();
        try {
            $postFactory = PostFactory::createHandler($request['category']);
            $post = $postFactory->update($this->postRepository, $post, $request);
            DB::commit();
            return $post;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateSubscriptionLevelForPost(Post $post, UpdateSubscriptionLevel $request): Post
    {
        $data = $request->validated();
        $currentSubscriptionLevel = $data['subscription_level_id'];
        $subscriptionLevels = auth()->user()
            ->subscriptionLevels()
            ->orderBy('order', 'ASC')
            ->pluck('id')
            ->toArray();
        $idxCurrentSubscriptionLevel = array_search($currentSubscriptionLevel, $subscriptionLevels);
        $allowedSubscriptionLevels = array_splice($subscriptionLevels, $idxCurrentSubscriptionLevel);
        $post = $this->postRepository->update($post, $data);
        $this->postRepository->syncLevels($post, $allowedSubscriptionLevels);
        return $post;
    }


    public function deletePost(Post $post): bool
    {
        return $this->postRepository->delete($post);
    }

    public function toggleLike(Post $post): void
    {
        $userId = auth()->id();
        if ($this->postRepository->hasLiked($post)) {
            $this->postRepository->detachLike($post, $userId);
        } else {
            $this->postRepository->attachLike($post, $userId);
        }
    }

    public function addRepost(Post $post): void
    {
        if ($this->postRepository->hasReposted($post)) {
            throw new ConflictHttpException();
        }
        $this->postRepository->attachRepost($post, auth()->id());
    }

    public function deleteRepost(Post $post): void
    {
        if (!$this->postRepository->hasReposted($post)) {
            throw new ConflictHttpException();
        }
        $this->postRepository->detachRepost($post, auth()->id());
    }
}
