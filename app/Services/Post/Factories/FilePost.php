<?php

namespace App\Services\Post\Factories;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\Post\Factories\Interfaces\PostInterface;
use Illuminate\Validation\ValidationException;

class FilePost extends AbstractPost implements PostInterface
{
    /**
     * @throws ValidationException
     */
    public function create(PostRepositoryInterface $postRepository, StoreRequest $request): Post
    {
        $this->validate($request);
        $post = parent::createPost($postRepository, $request, ['title', 'description', 'category', 'tags']);
        $postRepository->addMedia($post, $request['preview'], 'posts/previews');
        foreach ($request->file('files') as $file) {
            $postRepository->addMedia($post, $file, 'posts/files');
        }
        return $post;
    }

    /**
     * @throws ValidationException
     */
    public function update(PostRepositoryInterface $postRepository, Post $post, UpdateRequest $request): Post
    {
        $this->validate($request);
        $post = parent::updatePost($postRepository, $post, $request, ['title', 'description', 'category', 'tags']);
        $postRepository->clearMediaCollection($post);
        $postRepository->addMedia($post, $request['preview'], 'posts/previews');
        foreach ($request->file('files') as $file) {
            $postRepository->addMedia($post, $file, 'posts/files');
        }
        return $post;
    }

    /**
     * @throws ValidationException
     */
    function validate(UpdateRequest|StoreRequest $request): void
    {
        if (!$request->hasFile('preview')) {
            throw ValidationException::withMessages([
                'preview' => ['Обязательное поле'],
            ]);
        }
        if (!$request->hasFile('files')) {
            throw ValidationException::withMessages([
                'files' => ['Обязательное поле'],
            ]);
        }
    }
}
