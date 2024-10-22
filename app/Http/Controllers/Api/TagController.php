<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\StoreRequest;
use App\Http\Resources\Tag\TagResource;
use App\Services\TagService;
use Illuminate\Http\Response;

class TagController extends Controller
{
    public function __construct(private TagService $tagService)
    {
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        $tags = $this->tagService->getTags();
        return response()->json(['tag' => TagResource::collection($tags)]);
    }

    public function store(StoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $tag = $this->tagService->createTag($request);
        return response()->json(['tag' => TagResource::make($tag)], Response::HTTP_CREATED);
    }
}
