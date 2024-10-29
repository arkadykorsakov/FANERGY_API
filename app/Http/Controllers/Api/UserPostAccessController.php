<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\UserPostAccessService;

class UserPostAccessController extends Controller
{
    public function __construct(private UserPostAccessService $userPostAccessService){}

    public function buyShowAccessForPost(Post $post): \Illuminate\Http\Response
    {
        $this->userPostAccessService->buyShowAccessForPost($post);
        return response()->noContent();
    }
}
