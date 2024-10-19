<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Support\Facades\Gate;
use Throwable;
class PostController extends Controller
{
    public function __construct(private postService $postService)
    {
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        $posts = $this->postService->getPosts();
        return response()->json(['posts' => PostResource::collection($posts)]);
    }

    public function show(Post $post): \Illuminate\Http\JsonResponse
    {
        return response()->json(['post' => PostResource::make($post)]);
    }


    /**
     * @throws Throwable
     */
    public function store(StoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $post = $this->postService->createPost($request);
        return response()->json(['post' => PostResource::make($post)]);
    }

    /**
     * @throws Throwable
     */
    public function update(Post $post, UpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        Gate::authorize('update-post', $post);
        $post = $this->postService->updatePost($post, $request);
        return response()->json(['post' => PostResource::make($post)]);
    }

    public function destroy(Post $post): \Illuminate\Http\Response
    {
        Gate::authorize('delete-post', $post);
        $this->postService->deletePost($post);
        return response()->noContent();
    }

    public function toggleLike(Post $post): \Illuminate\Http\Response
    {
        $this->postService->toggleLike($post);
        return response()->noContent();
    }

    public function addRepost(Post $post): \Illuminate\Http\Response
    {
        Gate::authorize('add-repost-post', $post);
        $this->postService->addRepost($post);
        return response()->noContent();
    }

    public function deleteRepost(Post $post): \Illuminate\Http\Response
    {
        Gate::authorize('delete-repost-post', $post);
        $this->postService->deleteRepost($post);
        return response()->noContent();
    }
}
