<?php

namespace App\Http\Resources\Goal;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GoalResource extends JsonResource
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
			'description' => $this->description,
			'amount_collected' => $this->amount_collected,
			'total_collected' => $this->total_collected,
			'percentage' => $this->percentage,
			'user' => UserResource::make($this->user),
		];
	}
}
