<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nickname',
        'email',
        'password',
        'tg_link',
        'youtube_link',
        'twitch_link',
        'vk_link',
        'inst_link',
        'description',
        'role',
        'phone',
        'exists_adult_content'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'exists_adult_content' => 'boolean',
            'password' => 'hashed',
            'role' => Role::class
        ];
    }

    public function posts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function goals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Goal::class);
    }

    public function followers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_subscriptions', 'following_id', 'follower_id');
    }

    public function subscribes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_subscriptions', 'follower_id', 'following_id');
    }

    public function getIsFollowingAttribute(): bool
    {
        return $this->followers()->where('follower_id', auth()->id())->exists();
    }

    public function getIsFollowedAttribute(): bool
    {
        return $this->followers()->where('following_id', auth()->id())->exists();
    }

    public function blocklist()
    {
        return $this->belongsToMany(User::class, 'user_blocklist', 'user_id', 'blocked_user_id');
    }

    public function getIsUserBlockedByMeAttribute(): bool
    {
        return auth()->user()->blocklist()->where('blocked_user_id', $this->id)->exists();
    }

    public function getIsMeBlockedByUserAttribute(): bool
    {
        return $this->blocklist()->where('blocked_user_id', auth()->id())->exists();
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
        $this
            ->addMediaConversion('mini')
            ->format('webp')
            ->fit(Fit::Crop, 34, 34)
            ->nonQueued();
    }

    public function getAvatarAttribute(): array
    {
        $media = $this->getFirstMedia('avatars');


        if (!$media) {
            return [];
        }

        return [
            'pc' => $media->getUrl('pc'),
            'mobile' => $media->getUrl('mobile'),
            'mini' => $media->getUrl('mini'),
        ];
    }
}
