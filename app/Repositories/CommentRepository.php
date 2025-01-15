<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;

class CommentRepository implements CommentRepositoryInterface
{

    public function create(array $data): Comment
    {
        return Comment::create($data)->fresh();
    }

    public function update(Comment $comment, array $data): Comment
    {
        $comment->update($data);
        $comment->fresh();
        return $comment;
    }

    public function delete(Comment $comment): bool
    {
        return $comment->delete();
    }
}
