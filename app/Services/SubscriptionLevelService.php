<?php

namespace App\Services;

use App\Http\Requests\SubscriptionLevel\StoreRequest;
use App\Http\Requests\SubscriptionLevel\UpdateRequest;
use App\Repositories\Interfaces\SubscriptionLevelRepositoryInterface;
use App\Models\SubscriptionLevel;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Throwable;

class SubscriptionLevelService
{

	public function __construct(private SubscriptionLevelRepositoryInterface $subscriptionLevelRepository) {}

	/**
	 * @throws Throwable
	 */
	public function create(StoreRequest $request): SubscriptionLevel
	{
		DB::beginTransaction();
		try {
			$data = $request->validated();
			$data['user_id'] = $request->user()->id;
			$subscriptionLevel = $this->subscriptionLevelRepository->create($data);
			$this->subscriptionLevelRepository->addMedia($subscriptionLevel, $request->file('image'), 'access_levels/images');
			DB::commit();
			return $subscriptionLevel;
		} catch (Throwable $e) {
			DB::rollBack();
			throw $e;
		}
	}

	/**
	 * @throws Throwable
	 * @throws FileDoesNotExist
	 * @throws FileIsTooBig
	 */
	public function update(UpdateRequest $request, SubscriptionLevel $subscriptionLevel): SubscriptionLevel
	{
		DB::beginTransaction();
		try {
			$data = $request->validated();
			$this->subscriptionLevelRepository->update($subscriptionLevel, $data);
			$this->subscriptionLevelRepository->clearMediaCollection($subscriptionLevel, 'access_levels/images');
			$this->subscriptionLevelRepository->addMedia($subscriptionLevel, $request->file('image'), 'access_levels/images');
			DB::commit();
			return $subscriptionLevel;
		} catch (Throwable $e) {
			DB::rollBack();
			throw $e;
		}
	}

	public function delete(SubscriptionLevel $subscriptionLevel): bool
	{
		return $this->subscriptionLevelRepository->delete($subscriptionLevel);
	}
}
