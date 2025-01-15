<?php

namespace App\Services;

use App\Http\Requests\Comment\StoreRequest;
use App\Http\Requests\Comment\UpdateRequest;
use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;

class CommentService
{
    public function __construct(private CommentRepositoryInterface $commentRepository)
    {
    }

    public function createComment(int $postId, StoreRequest $request): Comment
    {
        $data = $request->validated();
        $data['post_id'] = $postId;
        $data['user_id'] = auth()->id();
        return $this->commentRepository->create($data);
    }

    public function updateComment(Comment $comment, UpdateRequest $request): Comment
    {
        $data = $request->validated();
        return $this->commentRepository->update($comment, $data);
    }

    public function deleteComment(Comment $comment): bool
    {
        return $this->commentRepository->delete($comment);
    }
}
