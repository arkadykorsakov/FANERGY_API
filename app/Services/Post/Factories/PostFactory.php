<?php

namespace App\Services\Post\Factories;

use App\Services\Post\Factories\Interfaces\PostInterface;
use Exception;

class PostFactory
{
    /**
     * @throws Exception
     */
    public static function createHandler(string $category): PostInterface
    {
        return match ($category) {
            "discord", "telegram" => new LinkPost(),
            "video" => new VideoPost(),
            "gallery" => new ImagePost(),
            "audio", "podcast" => new AudioPost(),
            "file" => new FilePost(),
            default => throw new \Exception('Unexpected match value'),
        };
    }
}
