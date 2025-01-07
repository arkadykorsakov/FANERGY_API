<?php

namespace App\Http\Resources\Billing;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillingResource extends JsonResource
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
            'system' => $this->system,
            'user_id' => $this->user_id,
            'external_card_id' => $this->external_card_id,
            'last_four_digits' => $this->last_four_digits,
            'is_main' => $this->is_main,
        ];
    }
}
