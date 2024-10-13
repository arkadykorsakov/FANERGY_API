<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\StoreRequest;
use App\Http\Resources\Tag\TagResource;
use App\Services\TagService;

class TagController extends Controller
{
	private TagService $tagService;

	public function __construct(TagService $tagService)
	{
		$this->tagService = $tagService;
	}

	public function index(): \Illuminate\Http\JsonResponse
	{
		$tags = $this->tagService->getTags();
		return response()->json(['tag' => TagResource::collection($tags)]);
	}

	public function store(StoreRequest $request): \Illuminate\Http\JsonResponse
	{
		$tag = $this->tagService->createTag($request);
		return response()->json(['tag' => TagResource::make($tag)]);
	}
}
