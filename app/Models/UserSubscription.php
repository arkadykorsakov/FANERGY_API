<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;

    protected $fillable = ['subscription_level_id', 'paid_subscription_start_date', 'paid_subscription_end_date'];

    protected function casts(): array
    {
        return [
            'paid_subscription_start_date' => 'date:Y-m-d',
            'paid_subscription_end_date' => 'date:Y-m-d',
        ];
    }
}
