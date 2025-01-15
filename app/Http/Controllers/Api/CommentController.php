<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreRequest;
use App\Http\Requests\Comment\UpdateRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function __construct(private CommentService $commentService)
    {
    }

    public function store(Post $post, StoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $comment = $this->commentService->createComment($post->id, $request);
        return response()->json(['comment' => CommentResource::make($comment)]);
    }

    public function update(Comment $comment, UpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        Gate::authorize('update-comment', $comment);
        $comment = $this->commentService->updateComment($comment, $request);
        return response()->json(['comment' => CommentResource::make($comment)]);
    }

    public function destroy(Comment $comment): \Illuminate\Http\Response
    {
        Gate::authorize('delete-comment', $comment);
        $this->commentService->deleteComment($comment);
        return response()->noContent();
    }
}
