<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'name' => $this->name,
            'nickname' => $this->nickname,
            'email' => $this->email,
            'tg_link' => $this->tg_link,
            'youtube_link' => $this->youtube_link,
            'twitch_link' => $this->twitch_link,
            'vk_link' => $this->vk_link,
            'inst_link' => $this->inst_link,
            'role' => $this->role,
            'avatar' => $this->avatar,
            'phone' => $this->phone,
            'exists_adult_content' => $this->exists_adult_content,
        ];
    }
}
