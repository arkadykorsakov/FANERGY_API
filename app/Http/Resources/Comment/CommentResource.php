<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'post_id' => $this->post_id,
            'parent_comment_id' => $this->parent_comment_id,
            'publish_date' => $this->publishDate,
            'is_edited' => $this->isEdited,
            'author' => UserResource::make($this->user),
            'content' => $this->content,
            'child_comments' => CommentResource::collection($this->childComments)
        ];
    }
}
