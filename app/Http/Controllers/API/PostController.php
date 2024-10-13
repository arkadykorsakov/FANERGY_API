<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
	private postService $postService;

	public function __construct(PostService $postService)
	{
		$this->postService = $postService;
	}

	public function index(): \Illuminate\Http\JsonResponse
	{
		$posts = $this->postService->getPosts();
		return response()->json(['post' => PostResource::collection($posts)]);
	}

	public function store(StoreRequest $request): \Illuminate\Http\JsonResponse
	{
		$post = $this->postService->createPost($request);
		return response()->json(['post' => PostResource::make($post)]);
	}

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
}
