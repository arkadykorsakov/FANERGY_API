<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'post_id', 'parent_comment_id', 'content'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
       return $this->belongsTo(User::class);
    }

    public function post(): \Illuminate\Database\Eloquent\Relations\BelongsTo{
        return $this->belongsTo(Post::class);
    }
    public function childComments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class, 'parent_comment_id', 'id');
    }

    public function getPublishDateAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    public function getIsEditedAttribute(): bool
    {
        return $this->updated_at > $this->created_at;
    }
}
