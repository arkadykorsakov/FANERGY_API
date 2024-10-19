<?php

namespace App\Services\Post\Factories;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\Post\Factories\Interfaces\PostInterface;
use Illuminate\Validation\ValidationException;

class LinkPost extends AbstractPost implements PostInterface
{
    /**
     * @throws ValidationException
     */
    public function create(PostRepositoryInterface $postRepository, StoreRequest $request): Post
    {
        $this->validate($request);
        $post = parent::createPost($postRepository, $request, ['title', 'description', 'category', 'tags', 'links']);
        $postRepository->addMedia($post, $request['preview'], 'posts/previews');
        return $post;
    }

    /**
     * @throws ValidationException
     */
    public function update(PostRepositoryInterface $postRepository, Post $post, UpdateRequest $request): Post
    {
        $this->validate($request);
        $post = parent::updatePost($postRepository, $post, $request, ['title', 'description', 'category', 'tags', 'links']);
        $postRepository->clearMediaCollection($post);
        $postRepository->addMedia($post, $request['preview'], 'posts/previews');
        return $post;
    }

    /**
     * @throws ValidationException
     */
    public function validate($request): void
    {
        if (empty($request['links'])) {
            throw ValidationException::withMessages([
                'links' => ['Обязательное поле'],
            ]);
        }
        if (!$request->hasFile('preview')) {
            throw ValidationException::withMessages([
                'preview' => ['Обязательное поле'],
            ]);
        }
    }
}
