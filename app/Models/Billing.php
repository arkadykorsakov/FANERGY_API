<?php

namespace App\Models;

use App\Enums\PaymentSystem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'external_card_id', 'last_four_digits', 'system', 'is_main'];

    protected function casts(): array
    {
        return [
            'system' => PaymentSystem::class,
            'is_main' => 'boolean',
        ];
    }
}
