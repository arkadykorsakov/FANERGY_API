<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
	use HasFactory;

	protected $fillable = ['title', 'description', 'amount_collected', 'total_collected', 'user_id'];

	protected $casts = ['amount_collected' => 'decimal:2', 'total_collected' => 'decimal:2'];

	public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function getPercentageAttribute(): float
	{
		if ((float)$this->total_collected == 0) {
			return 0;
		}
		return round(((float)$this->amount_collected * 100) / (float)$this->total_collected, 2);
	}
}
