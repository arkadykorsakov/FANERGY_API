<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\SubscriptionLevel\SubscriptionLevelResource;
use App\Http\Resources\Tag\TagResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'title' => $this->title,
            'category' => $this->category,
            'description' => $this->description,
            'publish_date' => $this->publishDate,
            'is_edited' => $this->isEdited,
            'author' => UserResource::make($this->author),
            'tags' => TagResource::collection($this->tags),
            'likes' => $this->likes()->count(),
            'has_liked' => $this->has_liked,
            'reposts' => $this->reposts()->count(),
            'has_reposted' => $this->has_reposted,
            'links' => $this->links,
            'preview' => $this->preview,
            'audios' => $this->audios,
            'video' => $this->video,
            'gallery' => $this->gallery,
            'files' => $this->files,
            'is_show' => $this->isShowContent,
            'comments' => CommentResource::collection($this->comments)
        ];
    }
}
