<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SubscriptionLevel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['title', 'description', 'price_per_month', 'user_id', 'order'];

    protected function casts(): array
    {
        return [
            'price_per_month' => 'decimal:2',
        ];
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('pc')
            ->format('webp')
            ->fit(Fit::Crop, 128, 128)
            ->nonQueued();
        $this
            ->addMediaConversion('mobile')
            ->format('webp')
            ->fit(Fit::Crop, 64, 64)
            ->nonQueued();
    }

    public function getImageAttribute(): array
    {
        $media = $this->getFirstMedia('subscription_levels/images');


        if (!$media) {
            return [];
        }

        return [
            'pc' => $media->getUrl('pc'),
            'mobile' => $media->getUrl('mobile'),
        ];
    }
}
