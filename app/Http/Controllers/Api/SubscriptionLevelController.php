<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionLevel\StoreRequest;
use App\Http\Requests\SubscriptionLevel\UpdateRequest;
use App\Http\Resources\SubscriptionLevel\SubscriptionLevelResource;
use App\Models\SubscriptionLevel;
use App\Services\SubscriptionLevelService;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Throwable;

class SubscriptionLevelController extends Controller
{
	public function __construct(private SubscriptionLevelService $subscriptionLevelService) {}

	/**
	 * @throws Throwable
	 */
	public function store(StoreRequest $request): \Illuminate\Http\JsonResponse
	{
		$subscriptionLevel = $this->subscriptionLevelService->create($request);
		return response()->json(['subscription_level' => SubscriptionLevelResource::make($subscriptionLevel)]);
	}

	/**
	 * @throws Throwable
	 * @throws FileDoesNotExist
	 * @throws FileIsTooBig
	 */
	public function update(UpdateRequest $request, SubscriptionLevel $subscriptionLevel): \Illuminate\Http\JsonResponse
	{
		$subscriptionLevel = $this->subscriptionLevelService->update($request, $subscriptionLevel);
		return response()->json(['subscription_level' => SubscriptionLevelResource::make($subscriptionLevel)]);
	}

	public function destroy(SubscriptionLevel $subscriptionLevel): \Illuminate\Http\Response
	{
		$this->subscriptionLevelService->delete($subscriptionLevel);
		return response()->noContent();
	}
}
