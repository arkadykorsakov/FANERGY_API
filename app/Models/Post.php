<?php

namespace App\Models;

use App\Enums\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	use HasFactory;

	protected $fillable = [
		'title',
		'description',
		'category',
		'user_id'
	];

	protected function casts(): array
	{
		return [
			'category' => Category::class
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
}
