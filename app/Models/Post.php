<?php

namespace App\Models;

use App\Enums\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use function Termwind\renderUsing;

class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'category',
        'user_id',
        'links'
    ];

    protected function casts(): array
    {
        return [
            'category' => Category::class,
            'links' => 'array'
        ];
    }

    public function getPublishDateAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    public function getIsEditedAttribute(): bool
    {
        return $this->updated_at > $this->created_at;
    }

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function likes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes_for_posts', 'post_id', 'user_id');
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class, 'post_id', 'id')->whereNull('parent_comment_id');
    }

    public function levels(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(SubscriptionLevel::class, 'post_subscription_levels');
    }

    public function reposts(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'reposts_for_posts', 'post_id', 'user_id');
    }

    public function getHasLikedAttribute(): bool
    {
        return $this->likes()->where('user_id', auth()->id())->exists();
    }

    public function getHasRepostedAttribute(): bool
    {
        return $this->reposts()->where('user_id', auth()->id())->exists();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('pc')
            ->format('webp')
            ->fit(Fit::Crop, 844, 444)
            ->nonQueued();
        $this
            ->addMediaConversion('mobile')
            ->format('webp')
            ->fit(Fit::Crop, 296, 296)
            ->nonQueued();
        $this
            ->addMediaConversion('pc_blur')
            ->format('webp')
            ->fit(Fit::Crop, 844, 444)
            ->blur(100)
            ->nonQueued();
        $this
            ->addMediaConversion('mobile_blur')
            ->format('webp')
            ->fit(Fit::Crop, 296, 296)
            ->blur(100)
            ->nonQueued();
    }

    public function getGalleryAttribute(): array
    {
        $media = $this->getMedia('posts/images');

        return $media->map(function ($item) {
            return [
                'pc' => $item->getUrl('pc'),
                'mobile' => $item->getUrl('mobile'),
                'pc_blur' => $item->getUrl('pc_blur'),
                'mobile_blur' => $item->getUrl('mobile_blur'),
            ];
        })->toArray();
    }

    public function getPreviewAttribute(): array
    {
        $media = $this->getFirstMedia('posts/previews');

        if (!$media) {
            return [];
        }

        return [
            'pc' => $media->getUrl('pc'),
            'mobile' => $media->getUrl('mobile'),
            'pc_blur' => $media->getUrl('pc_blur'),
            'mobile_blur' => $media->getUrl('mobile_blur'),
        ];
    }

    public function getAudiosAttribute(): array
    {
        $media = $this->getMedia('posts/audios');

        return $media->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'url' => $item->getUrl(),
                'size' => $item->size,
            ];
        })->toArray();
    }

    public function getVideoAttribute(): ?string
    {
        $media = $this->getFirstMedia('posts/videos');
        return $media?->getUrl();
    }

    public function getFilesAttribute(): array
    {
        $media = $this->getMedia('posts/files');

        return $media->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'url' => $item->getUrl(),
                'size' => $item->size,
            ];
        })->toArray();
    }

    public function getIsPaidForViewing(): bool
    {
        return $this->belongsToMany(Post::class, 'user_post_accesses', 'post_id')
            ->wherePivot('user_id', auth()->id())
            ->exists();
    }

    //TODO: нужен рефакторинг
    public function getIsShowContentAttribute(): bool
    {
        if ($this->price > 0) {
            return $this->getIsPaidForViewing();
        }
        if ($this->levels()->count()) {
            $userSubscriptionLevel = auth()->user()
                ->subscriptions()
                ->where('author_id', $this->user_id)
                ->value('subscription_level_id');
            return $this->levels->contains('id', $userSubscriptionLevel);
        }
        return true;
    }
}
