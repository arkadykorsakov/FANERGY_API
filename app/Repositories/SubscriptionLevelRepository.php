<?php

namespace App\Repositories;

use App\Models\SubscriptionLevel;
use App\Repositories\Interfaces\SubscriptionLevelRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class SubscriptionLevelRepository implements SubscriptionLevelRepositoryInterface
{
	public function create(array $data): SubscriptionLevel
	{
		return SubscriptionLevel::create($data)->fresh();
	}

	public function update(SubscriptionLevel $subscriptionLevel, array $data): SubscriptionLevel
	{
		$subscriptionLevel->update($data);
		return $subscriptionLevel->refresh();
	}

	public function delete(SubscriptionLevel $subscriptionLevel): bool
	{
		return $subscriptionLevel->delete();
	}

	/**
	 * @throws FileIsTooBig
	 * @throws FileDoesNotExist
	 */
	public function addMedia(SubscriptionLevel $subscriptionLevel, UploadedFile $file, string $collectionName): void
	{
		$subscriptionLevel->addMedia($file)
			->toMediaCollection($collectionName);
	}

	public function clearMediaCollection(SubscriptionLevel $subscriptionLevel, string $collectionName): void
	{
		$subscriptionLevel->clearMediaCollection($collectionName);
	}

    public function findById(int $subscriptionLevel): SubscriptionLevel
    {
        return SubscriptionLevel::where('id', $subscriptionLevel)->firstOrFail();
    }
}
